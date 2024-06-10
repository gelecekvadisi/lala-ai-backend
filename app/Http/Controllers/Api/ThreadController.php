<?php

namespace App\Http\Controllers\Api;

use Exception;
use Throwable;
use App\Models\ApiKey;
use App\Models\Generate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\StreamInterface;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ThreadController extends Controller
{
    private function getApiKey()
    {
        $api_keys = ApiKey::whereStatus(1)
            ->latest()
            ->get();

        // return $api_keys;

        if (count($api_keys) == 0) {
            throw new Exception("Yapay Zeka ile iletişim kurulamadı!", 422);
        }

        return $api_keys[0];
    }

    private function checkUserPlan($user, int $total_cost)
    {
        return null;
        if ($user->will_expire <= now()) {
            return response()->json(
                [
                    "message" => __(
                        'Plan süreniz sona erdi' . $user->will_expire
                    ),
                ],
                402
            );
        } else if ($user->credits < $total_cost) {
            return response()->json(
                [
                    "message" => __(
                        'Yeterli krediniz yok.'
                    ),
                ],
                402
            );
        }
        return null;
    }

    public function createThread(Request $request)
    {
        $request->validate([
            "message" => "nullable|string|max:1000"
        ]);
        $user = auth()->user();

        $text_settings = get_option("text-generate") ?? [];
        $total_cost = 0;//$text_settings["charge"] ?? 1;    //  Metin ve görsel oluşturmada kredi harcama kapatıldı.

        $userPlanMessage = $this->checkUserPlan($user, $total_cost);
        if (isset($userPlanMessage)) {
            return $userPlanMessage;
        }

        DB::beginTransaction();
        try {
            $api_key = $this->getApiKey();

            $response = Http::withHeaders([
                "Content-Type" => "application/json",
                "Authorization" => "Bearer " . $api_key->key,
                "OpenAI-Beta" => "assistants=v2",
            ])
                ->withoutVerifying()
                ->post(
                    "https://api.openai.com/v1/threads",
                    !isset($request->message) ? null : [
                        "messages" => [
                            [
                                "role" => "user",
                                "content" => $request->message,
                            ]
                        ],
                    ]
                );


            $result = $response->json();
            $status = $response->status();


            if ($status == 200 && isset($result["id"])) {
                DB::commit();
                return response()->json([
                    "status" => 200,
                    "message" => __("İşlem Başarılı"),
                    "data" => [
                        "id" => $result["id"]
                    ],
                ]);
            } else if (!isset($result["id"])) {
                throw new Exception("Konu oluşturulamadı!");
            } else {
                throw new Exception();
            }
        } catch (Throwable $th) {
            DB::rollback();
            return response()->json(
                [
                    "message" => __(
                        "Birşeyler yanlış gitti. Lütfen destek ekibi ile iletişime geçiniz. HATA:" .
                        $th
                    ),
                ],
                403
            );
        }
    }

    public function addMessage(Request $request)
    {
        $request->validate([
            "thread_id" => "required|string",
            "message" => "required|string|max:1000"
        ]);
        $user = auth()->user();

        $text_settings = get_option("text-generate") ?? [];
        $total_cost = 0;//$text_settings["charge"] ?? 1;    //  Metin ve görsel oluşturmada kredi harcama kapatıldı.

        $userPlanMessage = $this->checkUserPlan($user, $total_cost);
        if (isset($userPlanMessage)) {
            return $userPlanMessage;
        }

        DB::beginTransaction();
        try {
            $api_key = $this->getApiKey();

            $response = Http::withHeaders([
                "Content-Type" => "application/json",
                "Authorization" => "Bearer " . $api_key->key,
                "OpenAI-Beta" => "assistants=v2",
            ])
                ->withoutVerifying()
                ->post("https://api.openai.com/v1/threads/" . $request->thread_id . "/messages", [
                    "role" => "user",
                    "content" => $request->message,
                ]);


            $result = $response->json();
            $status = $response->status();

            return $result;


            if ($status == 200 && isset($result["id"])) {
                DB::commit();
                return response()->json([
                    "status" => 200,
                    "message" => __("İşlem Başarılı"),
                    "data" => $result,
                ]);
            } else if (!isset($result["id"])) {
                throw new Exception("Mesaj gönderilemedi!");
            } else {
                throw new Exception();
            }
        } catch (Throwable $th) {
            DB::rollback();
            return response()->json(
                [
                    "message" => __(
                        "Birşeyler yanlış gitti. Lütfen destek ekibi ile iletişime geçiniz. HATA:" .
                        $th
                    ),
                ],
                403
            );
        }
    }

    public function runs(Request $request)
    {
        $request->validate([
            "thread_id" => "required|string",
            "assistant_id" => "required|string",
        ]);

        DB::beginTransaction();
        try {
            $api_key = $this->getApiKey();
            $url = "https://api.openai.com/v1/threads/{$request->thread_id}/runs";

            $client = new Client();
            $response = $client->post($url, [
                'headers' => [
                    "Content-Type" => "application/json",
                    "Authorization" => "Bearer " . $api_key->key,
                    "OpenAI-Beta" => "assistants=v2",
                ],
                "json" => [
                    "assistant_id" => $request->assistant_id,
                    "stream" => true,
                ],
                "stream" => true,
                // 'allow_redirects' => true,
            ]);


            $statusCode = $response->getStatusCode();
            if ($statusCode === 200) {

                $stream = $response->getBody();

                $streamedResponse = new StreamedResponse(function () use ($stream) {
                    while (!$stream->eof()) {
                        $line = $stream->read(1024);

                        // Her event'i işlemek ve istemciye göndermek
                        if (strpos($line, 'data: ') !== false) {
                            $data = trim(substr($line, 6));
                            if (!empty($data)) {
                                echo $data;
                                ob_flush();
                                flush();
                            }
                        }
                    }
                });

                $streamedResponse->headers->set('Content-Type', 'text/event-stream');
                $streamedResponse->headers->set('Cache-Control', 'no-cache');
                // $streamedResponse->headers->set('Connection', 'keep-alive');
                return $streamedResponse;
            } else {
                return response()->json(['error' => 'Failed to fetch data'], $statusCode);
            }
        } catch (Throwable $th) {
            DB::rollback();
            return response()->json(
                [
                    "message" => __(
                        "Birşeyler yanlış gitti. Lütfen destek ekibi ile iletişime geçiniz. HATA:" .
                        $th
                    ),
                ],
                403
            );
        }
    }
}
