<?php

namespace App\Traits;

use Exception;
use App\Models\ApiKey;
use Illuminate\Support\Facades\Http;

trait AIContactFunctions
{
    public function getApiKey()
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

    public function checkUserPlan($user, int $total_cost)
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

    public function sendComplationsPrompt($api_key, $prompt_list)
    {
        $data = [];
        $response = Http::withHeaders([
            "Authorization" => "Bearer " . $api_key->key,
            "Content-Type" => "application/json",
        ])
            ->withoutVerifying()
            ->timeout(300000)
            ->post("https://api.openai.com/v1/chat/completions", [
                "messages" => $prompt_list,
                "model" => "gpt-4o",
                "max_tokens" => 4000,
                "temperature" => 1.0,
            ]);

        $result = $response->json();
        $status = $response->status();
        if ($status == 200 && isset($result["choices"])) {
            foreach ($result["choices"] as $choice) {
                $data[] = trim($choice["message"]["content"]);
            }
            return $data;
        }
    }
}