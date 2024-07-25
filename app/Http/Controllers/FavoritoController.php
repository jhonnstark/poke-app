<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFavoritoRequest;
use App\Http\Requests\UpdateFavoritoRequest;
use App\Models\Favorito;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class FavoritoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $favoritos = Favorito::all();
        return response()->json([
            'data' => $favoritos
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFavoritoRequest $request): JsonResponse
    {
        $user = User::find(1);
        $user->favoritos()->firstOrCreate($request->all());
        return response()->json([
            'message' => 'Favorito creado con exito'
        ], 201);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request): JsonResponse
    {
        $user = User::find(1);
        $favorito = $user->favoritos()->where('pokemon_id', $request->get('pokemon_id'))->first();

        if ($favorito) {
            $favorito->delete();
            return response()->json([
                'message' => 'Favorito eliminado con exito'
            ], 200);
        }

        return response()->json([
            'message' => 'Favorito no encontrado'
        ], 404);
    }
}
