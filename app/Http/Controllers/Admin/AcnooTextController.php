<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AcnooTextController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:text-generates-read')->only('index');
        $this->middleware('permission:text-generates-update')->only('update');
    }

    public function index()
    {
        $text_generate = get_option('text-generate');
        return view('admin.text-generates.index', compact('text_generate'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'max_tokens' => 'required|numeric',
            'model' => 'required|string',
            'temperature' => 'required|numeric',
            'charge' => 'required|numeric',
        ]);

        Option::updateOrCreate(['key' => 'text-generate'],
            ['value' => [
                'max_tokens' => $request->max_tokens,
                'model' => $request->model,
                'temperature' => $request->temperature,
                'charge' => $request->charge,
            ]
            ]);

        Cache::forget('text-generate');

        return response()->json(__('Text Generate updated successfully.'));
    }

}
