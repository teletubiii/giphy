<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\FavoriteGif;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Validator;



class GiphyController extends BaseController
{
    private static $baseUrl;
    private static $apiKey;

    public static function initialize()
    {
        self::$baseUrl = config('giphy.base_url');
        self::$apiKey = config('giphy.api_key');
    }

    public function __construct()
    {
        self::initialize();
    }

   /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'query' => 'required|string',
        ]);

        $query = $request->input('query');
        $limit = $request->input('limit', 10); // Default limit is 10
        $offset = $request->input('offset', 0); // Default offset is 0

        $response = Http::get(self::$baseUrl . "gifs/search", [
            'api_key' => self::$apiKey,
            'q' => $query,
            'limit' => $limit,
            'offset' => $offset
        ]);

        $data = $response->json();

        return $this->sendResponse($data['data'], 'GIFs retrieved successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): JsonResponse
    {
        $response = Http::get(self::$baseUrl . "gifs/{$id}", [
            'api_key' => self::$apiKey,
        ]);

        if ($response->successful()) {
            $data = $response->json();
            return $this->sendResponse($data['data'], 'GIF retrieved successfully.');
        } else {
            return $this->sendError('Failed to retrieve GIF.', $response->status());
        }
    }

    /**
     * Store a favorite GIF for a user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeFavorite(Request $request): JsonResponse
    {
        $rules = [
            'gif_id' => 'required|string|max:255',
            'alias' => 'required|string|max:255',
            'user_id' => 'required|integer',
        ];

        $messages = [
            'alias.required' => 'El alias es obligatorio.',
            'alias.string' => 'El alias debe ser un string.',
            'gif_id.required' => 'El gif_id es obligatorio.',
            'gif_id.string' => 'El gif_id debe ser un string.',
            'user_id.required' => 'El user_id es obligatorio.',
            'user_id.numeric' => 'El user_id debe ser un número.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return $this->sendError('Error de validación.', $validator->errors(), 400);
        }

        $favoriteGif = new FavoriteGif([
            'gif_id' => $request->input('gif_id'),
            'alias' => $request->input('alias'),
            'user_id' => $request->input('user_id'),
        ]);

        $favoriteGif->save();

        return $this->sendResponse($favoriteGif, 'GIF saved as favorite successfully.');
    }
}
