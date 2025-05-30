<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $table = 'movies';

    protected $casts = [
        'adult' => 'boolean',
        'video' => 'boolean',
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
        'backdrop_path',
        'original_language',
        'video',
        'genre_ids',
    ];
}
