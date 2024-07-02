<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Suggestion;
use Illuminate\Http\Request;

class AcnooCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::when(request('search'), function ($q) {
            $q->where('name', 'like', '%' . request('search') . '%');
        })
            ->where(function ($query) {
                $query->where('status', '=', 1);
            })
            ->orderBy('id', 'DESC')
            ->latest()
            ->with([
                'assistants' => function ($query) {
                    $query->take(50);
                }
            ])
            ->get();

        return response()->json($categories);
    }
}
