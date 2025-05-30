<?php

namespace App\Http\Controllers;

use App\Http\Requests\MoviesRequest;
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

        return response()->json([
            'message' => 'Movies retrieved successfully.',
            'data'    => $movies,
        ]);

    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function show(Request $request): JsonResponse
    {
        $filter = $request->query();

        $movie = $this->moviesApiService->getSearchedMovie($filter);

        if (empty($movie['results'])) {
            return response()->json([
                'message' => 'Movie not found.',
            ]);
        }

        return response()->json([
            'message' => 'Movie retrieved successfully.',
            'data'    => $movie,
        ]);
    }

    /**
     * @param MoviesRequest $request
     * @return JsonResponse
     */
    public function store(MoviesRequest $request): JsonResponse
    {
        $data = $request->only([
            'tmdb_id',
            'title',
            'overview',
            'popularity',
            'poster_path',
            'release_date',
            'vote_average',
            'vote_count',
            'adult',
            'genre_ids',
        ]);

        $movie = $this->moviesRepository->store($data);

        return response()->json([
            'message' => 'Movie created successfully.',
            'data'    => $movie,
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
