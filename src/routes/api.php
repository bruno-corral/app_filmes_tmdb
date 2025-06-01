<?php

use App\Http\Controllers\MoviesController;
use Illuminate\Support\Facades\Route;

Route::prefix('movies')->group(function () {
    Route::get('/{currentPage}', [MoviesController::class, 'index']);
    Route::get('/search/{movie}', [MoviesController::class, 'show']);
    Route::get('/search/favorite/movies/{currentPage}', [MoviesController::class, 'showFavoriteMovies']);
    Route::post('/add-movie', [MoviesController::class, 'storeFavoriteMovie']);
    Route::delete('/{id}', [MoviesController::class, 'destroy']);
});

Route::get('/genres', [MoviesController::class, 'genres']);