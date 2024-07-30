<?php

namespace App\Http\Controllers\Api;

use App\Models\GuideIntelligenceCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GuideIntelligenceCategoryController extends Controller
{
    // Listeleme
    public function index()
    {
        $categories = GuideIntelligenceCategory::all();
        return response()->json($categories);
    }

    // Tek bir kategoriyi gösterme
    public function show($id)
    {
        $category = GuideIntelligenceCategory::findOrFail($id);
        return response()->json($category);
    }

    // Yeni bir kategori oluşturma
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'google_sheet_name' => 'required|string|max:255',
            'image_name' => 'required|string|max:255',
            'inputs' => 'required|string',
            'instructions_generator' => 'required|string',
            'google_sheets_columns' => 'required|string',
            'status' => 'required|integer',
        ]);

        $category = GuideIntelligenceCategory::create($validatedData);

        return response()->json(['message' => 'Category created successfully', 'category' => $category], 201);
    }

    // Kategoriyi güncelleme
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'google_sheet_name' => 'sometimes|required|string|max:255',
            'image_name' => 'sometimes|required|string|max:255',
            'inputs' => 'sometimes|required|string',
            'instructions_generator' => 'sometimes|required|string',
            'google_sheets_columns' => 'sometimes|required|string',
            'status' => 'sometimes|required|integer',
        ]);

        $category = GuideIntelligenceCategory::findOrFail($id);
        $category->update($validatedData);

        return response()->json(['message' => 'Category updated successfully', 'category' => $category]);
    }

    // Kategoriyi silme
    public function destroy($id)
    {
        $category = GuideIntelligenceCategory::findOrFail($id);
        $category->delete();

        return response()->json(['message' => 'Category deleted successfully']);
    }
}
