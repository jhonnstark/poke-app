<?php

namespace App\Http\Controllers;

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

        $decode->results = array_map(function ($result) {
            $result->url = preg_replace('/^.*\/v2\//', '', $result->url);
            return $result;
        }, $decode->results);


        $nextOffset = $offset + $limit;
        $previousOffset = max(0, $offset - $limit);

        $nextUrl = URL::current() . '?offset=' . $nextOffset . '&limit=' . $limit;
        $previousUrl = URL::current() . '?offset=' . $previousOffset . '&limit=' . $limit;

        return response()->json([
            'results' => $decode->results,
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
