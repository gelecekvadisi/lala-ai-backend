<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\FavoriteAssistant;
use App\Http\Controllers\Controller;

class FavoriteAssistantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'user_id' => 'nullable|exists:users,id',
        ]);
        $favoriteAssistants = FavoriteAssistant::where('user_id', $request->user_id)->pluck('assistant_id');

        return response()->json(["data" => $favoriteAssistants]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return response()->json(["message" => "create favorite"], 200);
        // Return a view or form for creating a new favorite assistant.
        // This method is generally used for returning a view in a web application.
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // return response()->json(["message" => auth()->id()], 200); 

        $request->validate([
            // 'user_id' => 'nullable|exists:users,id',
            'assistant_id' => 'required|exists:suggestions,id',
        ]);

        $favorite = FavoriteAssistant::create([
            //  Zorunlu giriş kaldırılırsa aşağıda hata çıkma ihtimali var. 
            "user_id" => auth()->id(), // $request->user_id,
            "assistant_id" => $request->assistant_id,
        ]);

        return response()->json($favorite, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(FavoriteAssistant $favoriteAssistant)
    {
        return response()->json($favoriteAssistant);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FavoriteAssistant $favoriteAssistant)
    {
        // Return a view or form for editing the favorite assistant.
        // This method is generally used for returning a view in a web application.
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FavoriteAssistant $favoriteAssistant)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'assistant_id' => 'required|exists:suggestions,id',
        ]);

        $favoriteAssistant->update($request->all());

        return response()->json($favoriteAssistant);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FavoriteAssistant $favoriteAssistant)
    {
        $favoriteAssistant->delete();

        return response()->json(null, 204);
    }

    public function destroyByUserAndAssistant(Request $request)
    {
        // İsteği doğrulama
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'assistant_id' => 'required|exists:suggestions,id',
        ]);

        // Kullanıcı ve assistant_id ile eşleşen kaydı silme
        $deleted = FavoriteAssistant::where([
            'assistant_id' => $request->assistant_id,
            'user_id' => $request->user_id,
        ])->delete();

        if ($deleted) {
            return response()->json(null, 204);
        }

        return response()->json(['error' => 'Record not found'], 404);
    }
}