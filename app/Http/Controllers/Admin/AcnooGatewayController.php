<?php

namespace App\Http\Controllers\Admin;

use App\Models\Option;
use App\Helpers\HasUploader;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AcnooGatewayController extends Controller
{
    use HasUploader;

    public function __construct()
    {
        $this->middleware('permission:gateways-read')->only('index');
    }

    public function index(Request $request)
    {
        $gateways = Option::where('key', 'gateways')->first()->value ?? [];
        return view('admin.gateways.index', compact('gateways'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'paypal_is_live' => 'nullable|max:550',
            'paypal_client_id' => 'nullable|max:550',
            'paypal_client_secret' => 'nullable|max:550',
            
            'stripe_client_id' => 'nullable|max:550',
            'stripe_client_secret' => 'nullable|max:550',
            'stripe_is_live' => 'nullable|max:550',
            
            'sslcommerz_client_id' => 'nullable|max:550',
            'sslcommerz_client_secret' => 'nullable|max:550',
            'sslcommerz_is_live' => 'nullable|max:550',
        ]);
        
        Option::updateOrCreate(['key' => 'gateways'],
            ['value' => [
                'paypal_is_live' => $request->paypal_is_live ?? '0',
                'paypal_client_id' => $request->paypal_client_id,
                'paypal_client_secret' => $request->paypal_client_secret,

                'stripe_is_live' => $request->stripe_is_live ?? '0',
                'stripe_client_id' => $request->stripe_client_id,
                'stripe_client_secret' => $request->stripe_client_secret,

                'sslcommerz_is_live' => $request->sslcommerz_is_live ?? '0',
                'sslcommerz_client_id' => $request->sslcommerz_client_id,
                'sslcommerz_client_secret' => $request->sslcommerz_client_secret,
            ]
        ]);

        return response()->json(__('Gateways settings updated successfully.'));
    }
}
