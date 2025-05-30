<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $table = 'movies';

    protected $casts = [
        'genre_ids' => 'array',
    ];

    protected $fillable = [
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
    ];
}
