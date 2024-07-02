<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class AcnooCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Request'ten up_column parametresini al
        $upCategory = request('up_category');

        // up_column varsa, o değere sahip kategorileri al
        if ($upCategory) {
            $categories = Category::where('up_category', $upCategory)
                ->when(request('search'), function ($q) {
                    $q->where('name', 'like', '%' . request('search') . '%');
                })
                ->where('status', 1)
                ->orderBy('id', 'DESC')
                ->with([
                    'assistants' => function ($query) {
                        $query->take(50);
                    }
                ])
                ->get();
        } else {
            // up_column yoksa, up_category değeri null olan kategorileri al
            $categories = Category::whereNull('up_category')
                ->when(request('search'), function ($q) {
                    $q->where('name', 'like', '%' . request('search') . '%');
                })
                ->where('status', 1)
                ->orderBy('id', 'DESC')
                ->with([
                    'assistants' => function ($query) {
                        $query->take(50);
                    }
                ])
                ->get();
        }

        return response()->json($categories);
    }
}
