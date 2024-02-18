<?php


namespace App\Services\Interfaces;


use App\Http\Requests\Application\CreateMovieRequest;
use App\Http\Requests\Application\EditMovieRequest;
use App\Http\Requests\Application\SortMovieRequest;
use App\Models\Movie;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

interface MovieServiceInterface
{
    public function createMovie(CreateMovieRequest $request): array;
    public function getMovieItem(int $movieId): Movie;
    public function searchMovie(string $query): Collection;
    public function updateMovieRating(int $movieId): void;
    public function paginate(int $moviesPerView);
    public function all();
    public function getPersonOnMovie(int $movieId, Request $request): array;
    public function edit(int $movieId, EditMovieRequest $request);
    public function delete(int $movieId): void;
    public function publish(int $movieId): void;
    public function sort(string $sortQuery): Collection;
}
