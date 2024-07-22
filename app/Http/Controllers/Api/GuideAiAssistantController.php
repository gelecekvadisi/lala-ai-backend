<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GuideAiAssistant;

class GuideAiAssistantController extends Controller
{
    public function index()
    {
        $data = GuideAiAssistant::whereStatus(1)
            ->when(request('search'), function ($q) {
                $q->where('name', 'like', '%' . request('search') . '%');
            })
            ->latest()
            ->get();

        return response()->json($data);
    }
}
