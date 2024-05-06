<?php

namespace App\Http\Controllers\Api;

use App\Models\Option;
use App\Http\Controllers\Controller;

class AcnooApiKeyController extends Controller
{
    public function index()
    {
        $keys = Option::where('key', 'api_keys')->first()->value ?? ['chatgpt_api' => null, 'google_api' => null];
        return response()->json($keys);
    }
}
