<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GuideIntelligence;
use Illuminate\Http\Request;

class GuideIntelligenceController extends Controller
{
    // Listeleme
    public function index()
    {
        $intelligences = GuideIntelligence::with(['user', 'category'])->get();
        return response()->json($intelligences);
    }

    // Tek bir intelligence gösterme
    public function show($id)
    {
        $intelligence = GuideIntelligence::with(['user', 'category'])->findOrFail($id);
        return response()->json($intelligence);
    }

    // Yeni bir intelligence oluşturma
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|string|unique:guide_intelligences,id',
            'assistant_id' => 'required|string|max:255',
            'google_sheets_id' => 'required|string|max:255',
            'image_name' => 'required|string|max:255',
            'data' => 'required|string',
            'status' => 'required|integer',
            'user_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:guide_intelligence_categories,id',
        ]);

        $intelligence = GuideIntelligence::create($validatedData);

        return response()->json(['message' => 'Intelligence created successfully', 'intelligence' => $intelligence], 201);
    }

    // Intelligence güncelleme
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'assistant_id' => 'sometimes|required|string|max:255',
            'google_sheets_id' => 'sometimes|required|string|max:255',
            'image_name' => 'sometimes|required|string|max:255',
            'data' => 'sometimes|required|string',
            'status' => 'sometimes|required|integer',
            'user_id' => 'sometimes|required|exists:users,id',
            'category_id' => 'sometimes|required|exists:guide_intelligence_categories,id',
        ]);

        $intelligence = GuideIntelligence::findOrFail($id);
        $intelligence->update($validatedData);

        return response()->json(['message' => 'Intelligence updated successfully', 'intelligence' => $intelligence]);
    }

    // Intelligence silme
    public function destroy($id)
    {
        $intelligence = GuideIntelligence::findOrFail($id);
        $intelligence->delete();

        return response()->json(['message' => 'Intelligence deleted successfully']);
    }
}