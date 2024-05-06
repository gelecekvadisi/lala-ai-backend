<?php

namespace App\Http\Controllers\Api;

use App\Models\Option;
use App\Http\Controllers\Controller;

class AcnooAdnetworksController extends Controller
{
    public function index()
    {
        $adnetworks = Option::where('key', 'adnetwork')->first()->value ?? null;
        return response()->json([
            'status' => 200,
            'message' => __('Data fetched successfully.'),
            'data' => $adnetworks ?? [
                'video_ad_id' => null,
                'admob_app_id' => null,
                'video_ad_status' => null,
                'admob_app_id_status' => null,
            ],
        ]);
    }
}
