<?php


namespace App\Repositories\Interfaces;

use App\Models\Movie;
use Illuminate\Database\Eloquent\Collection;

interface MovieRepositoryInterface
{
    public function getByTitle(string $title);
    public function getById(int $id);
    public function getCollectionByQuery(string $query);
    public function create(array $data): Movie;
    public function save(Movie $movie);
    public function paginate(int $moviesPerView);
    public function all();
    public function syncGenres(Movie $movie, array $genres): void;
    public function attachGenres(Movie $movie, array $genres): void;
    public function updateAverageRating(Movie $movie): string;
    public function attachPersons(Movie $movie, int $personId, array $data): void;
    public function isPersonExists(Movie $movie, int $personId, string $role): bool;
    public function delete(Movie $movie): void;
    public function update(Movie $movie, array $data): void;
    public function getSortedMovies(string $column, string $direction): Collection;
}
