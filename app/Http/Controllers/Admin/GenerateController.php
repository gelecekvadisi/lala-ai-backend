<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Generate;
use Illuminate\Http\Request;

class GenerateController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:generates-read')->only('index');
        $this->middleware('permission:generates-delete')->only('destroy','deleteAll');
    }

    public function index(Request $request)
    {
        $query = Generate::with('user', 'category');

        if ($request->has('search')) {
            $search = '%' . $request->input('search') . '%';
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', $search)
                    ->orWhere('type', 'like', $search)
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', $search);
                    })
                    ->orWhereHas('category', function ($q) use ($search) {
                        $q->where('name', 'like', $search);
                    });
            });

            $generates = $query->latest()->get();
            return view('admin.generates.search', compact('generates'));
        } else {
            $generates = $query->latest()->paginate(10);
            return view('admin.generates.index', compact('generates'));
        }

    }

    public function show(string $id)
    {
        $generate = Generate::with('user', 'category')->findOrFail($id);
        return view('admin.generates.show', compact('generate'));
    }

    public function destroy(string $id)
    {
        Generate::findOrFail($id)->delete();
        return response()->json([
            'message' => __('Generate deleted successfully.'),
            'redirect' => route('admin.generates.index')
        ]);
    }

    public function deleteAll(Request $request)
    {
        Generate::whereIn('id', $request->ids)->delete();
        return response()->json([
            'message' => __('Generates deleted successfully.'),
            'redirect' => route('admin.generates.index')
        ]);
    }
}
