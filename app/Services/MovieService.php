<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class MovieService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = env('OMDB_API_KEY');
    }

    public function searchMovies($title)
    {
        $response = Http::get('http://www.omdbapi.com/', [
            'apikey' => $this->apiKey,
            's' => $title,
            'type' => 'movie',
        ]);

        if ($response->successful() && $response->json('Response') === 'True') {
            return $response->json('Search');
        }

        return null;
    }
}
