<?php

namespace App\Service;

use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

class MoviesApiService
{
    /**
     * @param array $filters = ['language', 'page', 'sort_by']
     * @return JsonResponse | array
     */
    public function getFavoriteMovies(array $filters = []): JsonResponse | array
    {
        $query = http_build_query($filters);

        if (!empty($query)) {
            $query = '?' . $query;
        }

        $response = Http::withToken(config('services.tmdb.api_key') )
                ->get(config('services.tmdb.endpoint_favorite_movies') . $query);

        if ($response->failed() || $response->status() === 404) {
            return response()->json([
                'message' => 'Favorite movies not found or something went wrong.',
                'data'    => $response->json(),
            ]);
        }

        return $response->json();
    }

    /**
     * @param string $filter
     * @return JsonResponse | array
     */
    public function getMovies(array $filter): JsonResponse | array
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
     * @param string $filter
     * @return : JsonResponse | array
     */
    public function getSearchedMovie(array $filter): JsonResponse | array
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