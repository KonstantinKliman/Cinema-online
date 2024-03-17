<?php


namespace App\Repositories;


use App\Models\Genre;
use App\Models\Movie;
use App\Repositories\Interfaces\GenreRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class GenreRepository implements GenreRepositoryInterface
{
    public function attach(Movie $movie, array $genres)
    {
        return $movie->genres()->attach($genres);
    }

    public function all(): Collection
    {
        return Genre::all();
    }

    public function detach(Movie $movie, int $genreId)
    {
        return $movie->genres()->detach($genreId);
    }

    public function create(array $data)
    {
        return Genre::firstOrCreate($data);
    }

    public function update(array $data, Genre $genre)
    {
        $genre->update($data);
    }

    public function delete(Genre $genre): void
    {
        $genre->delete();
    }
}
