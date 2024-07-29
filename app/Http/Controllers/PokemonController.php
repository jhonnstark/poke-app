<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use JsonException;
use Laravel\Octane\Exceptions\DdException;
use PokePHP\PokeApi;

class PokemonController extends Controller
{
    private PokeApi $api;

    public function __construct(PokeApi $api)
    {
        $this->api = $api;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws JsonException|DdException
     */
    public function index(Request $request): JsonResponse
    {
        $limit = $request->get('limit', 10);
        $offset = $request->get('offset', 0);

        $response = $this->api->resourceList('pokemon', $limit, $offset);
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
     * Display the specified resource.
     * @throws JsonException
     */
    public function show(string $id): JsonResponse
    {
        $response = $this->api->pokemon($id);
        try {
            $decode = json_decode($response, false, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            throw new JsonException($e->getMessage(), $e->getCode(), $e);
        }

        if (!isset($decode->name)) {
            return response()->json([
                'message' => 'Not found'
            ], 404);
        }

        $decode->img = 'https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/other/official-artwork/' . $decode->id . '.png';

        return response()->json([
            'data' => $decode
        ], 200);
    }
}
