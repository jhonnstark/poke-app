<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ImageProxyController extends Controller
{
    public function fetchImage(Request $request)
    {
        $imageUrl = $request->query('url');
        if (!$imageUrl) {
            return response()->json(['error' => 'URL parameter is required.'], 400);
        }

        $client = new Client();
        $response = $client->get($imageUrl, ['stream' => true]);
        $contentType = $response->getHeaderLine('Content-Type');

        return response($response->getBody()->getContents())
            ->header('Content-Type', $contentType);
    }
}
