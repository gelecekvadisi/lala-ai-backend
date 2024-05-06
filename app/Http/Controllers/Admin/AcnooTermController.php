<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AcnooTermController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:terms-read')->only('index');
        $this->middleware('permission:terms-update')->only('update');
    }

    public function index()
    {
        $term = Option::where('key','term')->first();

        return view('admin.terms.index', compact('term'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'term' => 'required|string'
        ]);

        Option::updateOrCreate(
            ['key' => 'term'],
            ['value' => $request->term]
        );

        cache::forget('term');

        return response()->json(__('Terms & Conditions updated successfully.'));
    }
}
