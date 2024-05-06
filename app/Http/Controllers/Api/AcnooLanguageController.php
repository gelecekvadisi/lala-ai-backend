<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AcnooLanguageController extends Controller
{
    public function index()
    {
        $lang = auth()->user()->lang;
        return response()->json([
            'status' => 200,
            'data' => $lang,
            'message' => __('Data fetched successfully.'),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'lang' => 'required|max:30|min:1|string'
        ]);

        auth()->user()->update([
            'lang' => $request->lang
        ]);

        return response()->json([
            'message' => __('Language updated successfully.')
        ]);
    }
}
