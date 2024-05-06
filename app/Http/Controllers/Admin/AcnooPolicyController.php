<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AcnooPolicyController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:policies-read')->only('index');
        $this->middleware('permission:policies-update')->only('update');
    }

    public function index()
    {
        $policy = Option::where('key','policy')->first();

        return view('admin.policies.index', compact('policy'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'policy' => 'required|string'
        ]);

        Option::updateOrCreate(
            ['key' => 'policy'],
            ['value' => $request->policy]
        );

        Cache::forget('policy');

        return response()->json(__('Privacy policy updated successfully.'));
    }
}
