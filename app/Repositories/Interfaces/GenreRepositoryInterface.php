<?php


namespace App\Repositories\Interfaces;


use App\Models\Movie;
use Illuminate\Database\Eloquent\Collection;

interface GenreRepositoryInterface
{
    public function create(Movie $movie, array $genres);
    public function findByGenreName(string $genreName);
    public function all() : Collection;
}
