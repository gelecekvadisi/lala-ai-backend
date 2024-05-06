<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Option;
use Illuminate\Http\Request;

class AcnooAdnetworkController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:adnetworks-read')->only('index');
        $this->middleware('permission:adnetworks-update')->only('update');
    }

    public function index()
    {
        $adnetwork = Option::where('key','adnetwork')->first();
        return view('admin.adnetworks.index', compact('adnetwork'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'video_ad_id' => 'required|string',
            'admob_app_id' => 'required|string',
        ]);
        
        Option::updateOrCreate(['key' => 'adnetwork'],
            ['value' => [
                'video_ad_id' => $request->video_ad_id,
                'admob_app_id' => $request->admob_app_id,
                'video_ad_status' => $request->video_ad_status ?? 0,
                'admob_app_id_status' => $request->admob_app_id_status ?? 0,
            ]
        ]);

        return response()->json(__('Adnetworks updated successfully.'));
    }

}
