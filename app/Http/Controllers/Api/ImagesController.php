<?php

namespace App\Http\Controllers\Api;

use Throwable;
use App\Models\ApiKey;
use App\Models\Generate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ImagesController extends Controller
{
    public function index() 
    {
        $images = Generate::where('user_id', auth()->id())->whereType('image')->get();
        return response()->json([
            'status' => 200,
            'message' => __('Data fetched successfully.'),
            'data' => $images,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'size' => 'required|string',
            'prompt' => 'required|string|max:1000',
        ]);

        $user = auth()->user();
        $image_settings = get_option('image-generate') ?? [];
        $total_cost = 0;//($image_settings['no_of_image'] ?? 1) * ($image_settings['charge'] ?? 2);     //  Metin ve görsel oluşturmada kredi harcama kapatıldı.

        if ($user->will_expire > now() || $user->credits >= $total_cost) {

            if ($user->will_expire < now() && $user->credits < $total_cost) {
                return response()->json([
                    'message' => __('You don\'t have enough credits.')
                ], 402);
            }

            DB::beginTransaction();
            try {

                $has_image = Generate::where('title', $request->prompt)->whereType('image')->first();
                
                $data = [];
                if ($has_image) {
                    $data = $has_image->data;
                } else {

                    $invalid_key_ids = [];
                    $api_keys = ApiKey::whereStatus(1)->latest()->get();

                    foreach ($api_keys as $api_key) {
                        $response = Http::withHeaders([
                            'Authorization' => "Bearer " . $api_key->key,
                            'Content-Type' => "application/json",
                        ])->post("https://api.openai.com/v1/images/generations", [
                            'size' => $request->size,
                            'prompt' => $request->prompt,
                            'n' => (int) $image_settings['no_of_image'] ?? 1,
                        ]);

                        // Decode the response JSON data
                        $result = $response->json();
                        $status = $response->status();
                        if ($status == 200) {
                            foreach ($result['data'] as $key => $image) {
                                $imageUrl = $image['url']; // URL of the image
                                $response = Http::get($imageUrl);

                                if ($response->successful()) {
                                    $imageData = $response->body();
                                    $filename = time() . '_' . rand(1, 1000) . '.' . 'png'; // should be dynamic
                                    $path = 'generated/images/' . $filename; // Specify the storage path
                                    Storage::put($path, $imageData);
                                    $data[$key] = $path;
                                }
                            }
                            break;
                        } else {
                            array_push($invalid_key_ids, $api_key->id);
                        }
                    }

                    ApiKey::whereIn('id', $invalid_key_ids)->update(['status' => 0]);
                    
                    if (empty($result['data'] ?? false)) {
                        return response()->json([
                            'message' => __('Please try again later or contact with admin')
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
                    'type' => 'image',
                    'user_id' => auth()->id(),
                    'title' => $request->prompt,
                    'image_sizes' => $request->size,
                    'cost_credits' => (!$user->will_expire || $user->will_expire < now()) ? $total_cost : 0,
                ]);

                sendNotification($generate->id, route('admin.generates.index', ['id' => $generate->id]), __('New images generated.'), $user);

                DB::commit();
                return response()->json([
                    'status' => 200,
                    'message' => __('Data fetched successfully.'),
                    'data' => $data,
                ]);

            } catch (Throwable $th) {
                DB::rollback();
                return response()->json([
                    'message' => __('Something was wrong, Please contact with author.')
                ], 403);
            }

        } else {
            return response()->json([
                'message' => __('Your plan has been expired & You don\'t have enough credits.')
            ], 402);
        }
    }
}
