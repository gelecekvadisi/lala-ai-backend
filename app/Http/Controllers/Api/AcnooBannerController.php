<?php

namespace App\Http\Controllers\Api;

use App\Models\Banner;
use App\Http\Controllers\Controller;

class AcnooBannerController extends Controller
{
    public function index()
    {
        $banners = Banner::whereStatus(1)->with('category')->latest()->get();
        return response()->json([
            'status' => 200,
            'message' => __('Data fetched successfully.'),
            'data' => $banners,
        ]);
    }
}
