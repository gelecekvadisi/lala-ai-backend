<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AcnooImageController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:image-generates-read')->only('index');
        $this->middleware('permission:image-generates-update')->only('update');
    }

    public function index()
    {
        $image_generate = get_option('image-generate');
        return view('admin.image-generates.index', compact('image_generate'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'no_of_image' => 'required|numeric',
            'charge' => 'required|numeric',
        ]);

        Option::updateOrCreate(['key' => 'image-generate'],
            ['value' => [
                'no_of_image' => $request->no_of_image,
                'charge' => $request->charge,
            ]
            ]);

        cache::forget('image-generate');

        return response()->json(__('Image generate settings updated.'));
    }
}