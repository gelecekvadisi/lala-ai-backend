<?php

namespace App\Http\Controllers\Api;

use Throwable;
use App\Models\ApiKey;
use App\Models\Generate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class TextsController extends Controller
{
    public function index()
    {
        $texts = Generate::where('user_id', auth()->id())
                    ->whereType('text')
                    ->when(request('category_id'), function($q) {
                        $q->where('category_id', request('category_id'));
                    })
                    ->latest()
                    ->get();

        return response()->json([
            'status' => 200,
            'message' => __('Data fetched successfully.'),
            'data' => $texts,
        ]);
    }
    
    public function store(Request $request)
    {
        $request->merge([
                "prompt"=> json_decode($request->prompt, true),
            ])->validate([
            "prompt" => "required|array",
            "prompt.*.role" => "required|string",
            "prompt.*.content" => "required|string|max:5000",
            // "prompt.*.content" => "required|string",
            "category_id" => "nullable|exists:categories,id",
            "file" => "file|mimes:pdf",
        ]);

        $user = auth()->user();
        $text_settings = get_option("text-generate") ?? [];
        $total_cost = 0;//$text_settings["charge"] ?? 1;    //  Metin ve görsel oluşturmada kredi harcama kapatıldı.

        if ($user->will_expire > now() || $user->credits >= $total_cost) {
            if ($user->will_expire < now() && $user->credits < $total_cost) {
                return response()->json(
                    [
                        "message" => __('You don\'t have enough credits.'),
                    ],
                    402
                );
            }
            
            $prompt_list = $request->prompt;
            
            //  Aşağıdaki kod Prompt uzunluğu 1000 karakterden uzun olduğunda 
            //  baştan başlayarak promptları siler
            /*while (strlen(json_encode($prompt_list)) >= 1000 && count($prompt_list)>1) {
                array_shift($prompt_list);
            }*/

            DB::beginTransaction();
            try {
                $data = [];
                $invalid_key_ids = [];
                $api_keys = ApiKey::whereStatus(1)
                    ->latest()
                    ->get();

                foreach ($api_keys as $api_key) {
                    //  SEND FILE TO CHAT-GPT
                    if ($request->hasFile("file")) {
                        $file = $request->file('file');
                        $fileResponse = Http::withHeaders([
                            "Authorization" => "Bearer " . $api_key->key,
                            // "Content-Type" => "application/json",
                        ])
                        ->timeout(300000)
                        ->post("https://api.openai.com/v1/files", [
                                "purpose" => "assistants",
                                "file" => $file,
                            ]);
                            return response()->json([
                                    "message" => "file upload successed!",
                                ]);
                    } else {
                        return response()->json([
                                    "message" => "file not found!",
                                    "request" => $request->file,
                                ]);
                    }
                    //  SEND PROMPT TO CHAT-GPT
                    $response = Http::withHeaders([
                        "Authorization" => "Bearer " . $api_key->key,
                        "Content-Type" => "application/json",
                    ])
                    ->timeout(300000)
                    ->post("https://api.openai.com/v1/chat/completions", [
                        "messages" => $prompt_list,
                        "model" => "gpt-4-turbo-preview",
                        "max_tokens" => 4000,
                        "temperature" => 1.0,
                    ]);
                    
                    $result = $response->json();
                    $status = $response->status();
                    if ($status == 200 && isset($result["choices"])) {
                        foreach ($result["choices"] as $choice) {
                            $data[] = trim($choice["message"]["content"]);
                        }
                        break;
                    } else {
                        array_push($invalid_key_ids, $api_key->id);
                    }
                }

                ApiKey::whereIn("id", $invalid_key_ids)->update([
                    "status" => 0,
                ]);

                if (empty($data)) {
                    return response()->json(
                        [
                            "message" => __(
                                "Please try again later or contact with admin."
                            ),
                        ],
                        422
                    );
                }

                if (!$user->will_expire || $user->will_expire < now()) {
                    $user->update([
                        "credits" => $user->credits - $total_cost,
                    ]);
                }
                
                $titleBase = $prompt_list[count($prompt_list)-1]["content"];
                $title = substr($titleBase, 0, 40);
                if (strlen($titleBase) > 40) {
                    $title = $title."...";
                }
                // $title = "Prompt";

                $generate = Generate::create([
                    "data" => $data,
                    "user_id" => auth()->id(),
                    "title" => $title,
                    "category_id" => $request->category_id,
                    "cost_credits" =>
                        !$user->will_expire || $user->will_expire < now()
                            ? $total_cost
                            : 0,
                ]);

                sendNotification(
                    $generate->id,
                    route("admin.generates.index", ["id" => $generate->id]),
                    __("New texts generated."),
                    $user
                );

                DB::commit();
                return response()->json([
                    "status" => 200,
                    "message" => __("Data fetched successfully."),
                    "data" => $data,
                ]);
            } catch (Throwable $th) {
                DB::rollback();
                return response()->json(
                    [
                        "message" => __(
                            "Something was wrong, Please contact with author. ERROR:" .
                                $th
                        ),
                    ],
                    403
                );
            }
        } else {
            return response()->json(
                [
                    "message" => __(
                        'Your plan has been expired & You don\'t have enough credits.'
                    ),
                ],
                402
            );
        }
    }

    /*public function store(Request $request)
    {
        $request->validate([
            'prompt' => 'required|string|max:1000',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $user = auth()->user();
        $text_settings = get_option('text-generate') ?? [];
        $total_cost = $text_settings['charge'] ?? 1;

        if ($user->will_expire > now() || $user->credits >= $total_cost) {

            if ($user->will_expire < now() && $user->credits < $total_cost) {
                return response()->json([
                    'message' => __('You don\'t have enough credits.')
                ], 402);
            }
            
            Yukarıdaki düzenlenmiş store() fonksiyonunda $request->prompt listesi prompt_list değişkenine alınıp oradan işlem yapılıyor. (Yeni değişken üzerinden işlemler yapılmazsa, listeden silme yapılamıyor.)

            DB::beginTransaction();
            try {

                $has_content = Generate::where('title', $request->prompt)->whereType('text')->first();

                $data = [];
                if ($has_content) {
                    $data = $has_content->data;
                } else {

                    $invalid_key_ids = [];
                    $api_keys = ApiKey::whereStatus(1)->latest()->get();

                    foreach ($api_keys as $api_key) {
                        $response = Http::withHeaders([
                            'Authorization' => "Bearer " . $api_key->key,
                            'Content-Type' => "application/json",
                        ])->post("https://api.openai.com/v1/chat/completions", [
                            //'prompt' => $request->prompt,
                            'messages' => [
                                [
                                    'role'=> 'user',
                                    'content'=> $request->prompt
                                ]
                            ],
                            'model' => 'gpt-3.5-turbo', //$text_settings['model'] ?? 'text-davinci-003',
                            'max_tokens' => 4000,    //  (int) $text_settings['max_tokens'] ?? 4000, // Should be change.
                            'temperature' => 1.0,    //  (float) $text_settings['temperature'] ?? 1.0,
                        ]);

                        // Decode the response JSON data
                        $result = $response->json();
                        $status = $response->status();
                        if ($status == 200) {
                            break;
                        } else {
                            array_push($invalid_key_ids, $api_key->id);
                        }
                    }

                    ApiKey::whereIn('id', $invalid_key_ids)->update(['status' => 0]);

                    if ($result['choices'] ?? false) {
                        foreach ($result['choices'] as $key => $content) {
                            $data[$key] = trim($content['message']['content']);
                        }
                    } else {
                        // $apiKeysJson = jsonEncode($api_keys);
                        return response()->json([
                            'message' => __('Please try again later or contact with admin. RESPONSE:' . $result),
                        ], 422);
                    }
                }

                if (!$user->will_expire || $user->will_expire < now()) {
                    $user->update([
                        'credits' => $user->credits - $total_cost
                    ]);
                }

                $generate = Generate::create([
                    'data' => $data,
                    'user_id' => auth()->id(),
                    'title' => $request->prompt,
                    'category_id' => $request->category_id,
                    'cost_credits' => (!$user->will_expire || $user->will_expire < now()) ? $total_cost : 0,
                ]);

                sendNotification($generate->id, route('admin.generates.index', ['id' => $generate->id]), __('New texts generated.'), $user);

                DB::commit();
                return response()->json([
                    'status' => 200,
                    'message' => __('Data fetched successfully.'),
                    'data' => $data,
                ]);

            } catch (Throwable $th) {
                DB::rollback();
                return response()->json([
                    'message' => __('Something was wrong, Please contact with author. ERROR:'.$th)
                ], 403);
            }
        } else {
            return response()->json([
                'message' => __('Your plan has been expired & You don\'t have enough credits.')
            ], 402);
        }
    }*/
}
