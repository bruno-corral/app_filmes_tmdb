<?php

namespace App\Repositories;

use App\Models\Movie;

class MoviesRepository
{
    public function __construct(public Movie $movie) {}
    
    public function index()
    {
        return $this->movie->all();
    }

    public function show($id)
    {
        return $this->movie->find($id);
    }

    public function store(array $data)
    {
        return $this->movie->create($data);
    }

    public function delete(Movie $movie)
    {
        return $movie->delete();
    }
}