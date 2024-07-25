<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use JsonException;
use PokePHP\PokeApi;

class PokemonController extends Controller
{
    /**
     * Display a listing of the resource.
     * @throws JsonException
     */
    public function index(Request $request): JsonResponse
    {
        $api = new PokeApi();
        $limit = $request->get('limit', 10);
        $offset = $request->get('offset', 0);

        $response = $api->resourceList('pokemon', $limit, $offset);
        $decode = json_decode($response, false, 512, JSON_THROW_ON_ERROR);

        $favorites = User::find(1)->favoritos->pluck('pokemon_id')->toArray();

        $results = array_map(function ($result) use ($favorites) {
            $result->url = preg_replace('/^.*\/v2\//', '', $result->url);
            $result->id = (int) preg_replace('/\D/', '', $result->url);
            $result->is_favorito = in_array($result->id, $favorites, true);
            return $result;
        }, $decode->results);


        $nextOffset = $offset + $limit;
        $previousOffset = max(0, $offset - $limit);

        $nextUrl = URL::current() . '?offset=' . $nextOffset . '&limit=' . $limit;
        $previousUrl = URL::current() . '?offset=' . $previousOffset . '&limit=' . $limit;

        return response()->json([
            'results' => $results,
            'next' => $nextUrl,
            'previous' => $previousUrl
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return 'store';
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
