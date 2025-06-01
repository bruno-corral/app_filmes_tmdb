<?php

namespace App\Http\Controllers;

use App\Repositories\MoviesRepository;
use App\Service\MoviesApiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MoviesController extends Controller
{
    public function __construct( 
        public MoviesRepository $moviesRepository,
        public MoviesApiService $moviesApiService) {}

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $filter = $request->query();

        $movies = $this->moviesApiService->getMovies($filter);

        if (empty($movies['results'])) {
            return response()->json([
                'message' => 'Movies not found.',
            ]);
        }

        return response()->json([
            'message' => 'Movies retrieved successfully.',
            'data'    => $movies,
        ]);

    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function show($movie): JsonResponse
    {
        $movie = $this->moviesApiService->getSearchedMovie($movie);

        if (empty($movie['results'])) {
            return response()->json([
                'message' => 'Movie not foundDD.',
            ]);
        }

        return response()->json([
            'message' => 'Movie retrieved successfully.',
            'data'    => $movie,
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function showFavoriteMovies(Request $request): JsonResponse
    {
        $movies = $this->moviesApiService->getFavoriteMovies($request->method(), $request->currentPage);

        if (empty($movies['results'])) {
            return response()->json([
                'message' => 'Favorite movies not found.',
            ]);
        }

        return response()->json([
            'message' => 'Favorite movies retrieved successfully.',
            'data'    => $movies,
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function storeFavoriteMovie(Request $request): JsonResponse | array
    {
        $movieId = trim($request->movieId);

        $movieCreatedOnApi = $this->moviesApiService->addFavoriteMovie($movieId);

        if ($movieCreatedOnApi['success'] === false) {
            return [
                'data' => $movieCreatedOnApi['data']
            ];
        }

        $favoriteMovies = $this->showFavoriteMovies($request, $request->method());

        $lastMovie = collect(collect($favoriteMovies)->get('original')['data']['results'])->last();

        $data = [
            'tmdb_id' => $lastMovie['id'],
            'title' => $lastMovie['original_title'],
            'overview' => $lastMovie['overview'],
            'popularity' => $lastMovie['popularity'],
            'poster_path' => $lastMovie['poster_path'],
            'release_date' => $lastMovie['release_date'],
            'vote_average' => $lastMovie['vote_average'],
            'vote_count' => $lastMovie['vote_count'],
            'adult' => $lastMovie['adult'],
            'backdrop_path' => $lastMovie['backdrop_path'],
            'original_language' => $lastMovie['original_language'],
            'video' => $lastMovie['video'],
            'genre_ids' => $lastMovie['genre_ids'],
        ];

        $movie = $this->moviesRepository->store($data);

        return response()->json([
            'message' => 'Movie created successfully.',
            'data'    => $movie,
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function genres(Request $request): JsonResponse
    {
        $filter = $request->query();

        $genres = $this->moviesApiService->getGenres($filter);

        return response()->json([
            'message' => 'Genres retrieved successfully.',
            'data'    => $genres,
        ]);
    }

    /**
     * @param string $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $movie = $this->moviesRepository->show($id);

        if (!$movie) {
            return response()->json([
                'message' => 'Movie not found.',
            ], 404);
        }

        $this->moviesRepository->delete($movie);

        return response()->json([
            'message' => 'Movie deleted successfully.',
        ], 200);
    }
}
