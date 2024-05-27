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
    public function index()
    {
        // return response()->json([
        //     "message"=> "İstek çalışıyor",
        // ], 200);
        // return view('favorite_assistant.index');
        $favorites = FavoriteAssistant::all();
        return response()->json($favorites);
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
            'user_id' => 'required|exists:users,id',
            'assistant_id' => 'required|exists:categories,id',
        ]);

        $favorite = FavoriteAssistant::create([
            //  Zorunlu giriş kaldırılırsa aşağıda hata çıkma ihtimali var. 
            "user_id" => $request->user_id, //auth()->id(),
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
            'assistant_id' => 'required|exists:categories,id',
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
}