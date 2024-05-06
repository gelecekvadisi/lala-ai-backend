<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Suggestion;

class AcnooSuggestionsController extends Controller
{
    public function index()
    {
        $suggestions = Suggestion::whereStatus(1)
                        ->when(request('category_id'), function($q) {
                            $q->where('category_id', request('category_id'));
                        })
                        ->when(request('search'), function($q) {
                            $q->where('suggestions', 'like', '%'.request('search').'%');
                        })
                        ->latest()
                        ->get();

        return response()->json($suggestions);
    }
}
