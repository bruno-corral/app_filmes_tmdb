<?php

namespace App\Service;

use Illuminate\Support\Facades\Http;

class MoviesApiService
{
    /**
     * @param string $filter
     * @return mixed
     */
    public function getMovies($filter): mixed
    {
        $filterParam = isset($filter['with_genres']) && $filter['with_genres'] !== null
            ? '?with_genres=' . urlencode(trim($filter['with_genres']))
            : '';

        $response = Http::withToken(config('services.tmdb.api_key') )
                ->get(config('services.tmdb.endpoint_movies') . $filterParam);

        if ($response->failed() || $response->status() === 404) {
            return response()->json([
                'message' => 'Movies not found or something went wrong.',
                'data'    => $response->json(),
            ]);
        }

        return $response->json();
    }

    /**
     * @param string $movie
     * @return mixed
     */
    public function getSearchedMovie($filter): mixed
    {
        $filterMovie = isset($filter['query']) && $filter['query'] !== null
            ? '?query=' . urlencode(trim($filter['query']))
            : '';
            
        $response = Http::withToken(config('services.tmdb.api_key'))
            ->get(config('services.tmdb.endpoint_one_movie') . $filterMovie);

        if ($response->failed() || $response->status() === 404) {
            return response()->json([
                'message' => 'Movie not found or something went wrong.',
                'data'    => $response->json(),
            ]);
        }

        return $response->json();
    }
}