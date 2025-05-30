<?php

namespace App\Service;

use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

class MoviesApiService
{
    /**
     * @param array $filters = ['language', 'page', 'sort_by']
     * @param string $method
     * @return JsonResponse | array
     */
    public function getFavoriteMovies(array $filters = [], $method = 'GET'): JsonResponse | array
    {
        if ($method === 'GET') {
            $query = http_build_query($filters);

            if (!empty($query)) {
                $query = '?' . $query;
            }

            $response = Http::withToken(config('services.tmdb.api_key') )
                    ->get(config('services.tmdb.endpoint_favorite_movies') . $query);

            if ($response->failed() || $response->status() === 404) {
                return [
                    'message' => 'Favorite movies not found or something went wrong.',
                    'data'    => $response->json(),
                ];
            }

            return $response->json();
        }

        if ($method === 'POST') {
            $response = Http::withToken(config('services.tmdb.api_key') )
                    ->get(config('services.tmdb.endpoint_favorite_movies'));

            if ($response->failed() || $response->status() === 404) {
                return [
                    'message' => 'Favorite movies not found or something went wrong.',
                    'data'    => $response->json(),
                ];
            }

            $response = Http::withToken(config('services.tmdb.api_key') )
                    ->get(config('services.tmdb.endpoint_favorite_movies') . '?page=' . $response->json()['total_pages']);

            if ($response->failed() || $response->status() === 404) {
                return [
                    'message' => 'Favorite movies not found or something went wrong.',
                    'data'    => $response->json(),
                ];
            }

            return $response->json();
        }

        return [];
    }

    /**
     * @param array $body ['media_type', 'media_id', 'favorite']
     * @return : JsonResponse | array
     */
    public function addFavoriteMovie(array $body): JsonResponse | array
    {
        $response = Http::withToken(config('services.tmdb.api_key'))
            ->post(config('services.tmdb.endpoint_add_favorite_movies') . '?session_id=' . config('services.tmdb.endpoint_session_id'), [
                'media_type' => $body['media_type'],
                'media_id' => $body['media_id'],
                'favorite' => $body['favorite'],
            ]);

        if ($response->failed() || $response->status() === 404) {
            return [
                'success' => false,
                'message' => 'Movie not found or something went wrong.',
                'data'    => $response->json(),
            ];
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
            return [
                'message' => 'Movies not found or something went wrong.',
                'data'    => $response->json(),
            ];
        }

        return $response->json();
    }

    /**
     * @param string $filter
     * @return : JsonResponse | array
     */
    public function getSearchedMovie($movie): JsonResponse | array
    {
        $filterMovie = isset($movie) && $movie !== null
            ? '?query=' . urlencode(trim($movie))
            : '';
            
        $response = Http::withToken(config('services.tmdb.api_key'))
            ->get(config('services.tmdb.endpoint_one_movie') . $filterMovie);

        if ($response->failed() || $response->status() === 404) {
            return [
                'message' => 'Movies not found or something went wrong.',
                'data'    => $response->json(),
            ];
        }

        return $response->json();
    }

    /**
     * @param string $filter
     * @return : JsonResponse | array
     */
    public function getGenres(array $filter): JsonResponse | array
    {
        $filterParam = isset($filter['language']) && $filter['language'] !== null
            ? '?language=' . urlencode(trim($filter['language']))
            : '';

        $response = Http::withToken(config('services.tmdb.api_key') )
                ->get(config('services.tmdb.endpoint_genres') . $filterParam);

        if ($response->failed() || $response->status() === 404) {
            return [
                'message' => 'Genres not found or something went wrong.',
                'data'    => $response->json(),
            ];
        }

        return $response->json();
    }
}