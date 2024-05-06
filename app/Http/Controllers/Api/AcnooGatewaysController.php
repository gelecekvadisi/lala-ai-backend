<?php

namespace App\Http\Controllers\Api;

use App\Models\Option;
use App\Http\Controllers\Controller;

class AcnooGatewaysController extends Controller
{
    public function index()
    {
        $gateways = Option::where('key', 'gateways')->first()->value ?? [];
        return response()->json([
            'status' => 200,
            'message' => __('Data fetched successfully.'),
            'data' => !empty($gateways) ? $gateways : [
                'paypal_is_live' => '',
                'paypal_client_id' => '',
                'paypal_client_secret' => '',

                'stripe_is_live' => '',
                'stripe_client_id' => '',
                'stripe_client_secret' => '',
                
                'sslcommerz_is_live' => '',
                'sslcommerz_client_id' => '',
                'sslcommerz_client_secret' => '',
            ]
        ]);
    }
}
