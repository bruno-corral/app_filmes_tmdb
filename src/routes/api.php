<?php

use App\Http\Controllers\MoviesController;
use Illuminate\Support\Facades\Route;

Route::apiResource('movies', MoviesController::class);
Route::get('/movies/search/{movie}', [MoviesController::class, 'show']);
Route::get('/movies/search/favorite/movies/{currentPage}', [MoviesController::class, 'showFavoriteMovies']);
Route::post('/movies/add-movie', [MoviesController::class, 'storeFavoriteMovie']);

Route::get('/genres', [MoviesController::class, 'genres']);