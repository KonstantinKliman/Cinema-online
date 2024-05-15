<?php


namespace App\Repositories;

use App\Models\Movie;
use App\Repositories\Interfaces\MovieRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection as SupportCollection;

class MovieRepository implements MovieRepositoryInterface
{

    public function getByTitle(string $title)
    {
        return Movie::where('title', $title)->first();
    }

    public function getById(int $id)
    {
        return Movie::query()->where('id', $id)->get();
    }

    public function getCollectionByQuery(string $query)
    {
        return Movie::where('title', 'LIKE', '%' . $query . '%')->get();
    }

    public function create(array $data): Movie
    {
        return Movie::create($data);
    }

    public function save(Movie $movie): bool
    {
        return $movie->save();
    }

    public function paginate(int $moviesPerView): LengthAwarePaginator
    {
        return Movie::query()->where('is_published', '1')->paginate($moviesPerView);
    }

    public function all(): Collection
    {
        return Movie::all();
    }

    public function attachGenres(Movie $movie, array $genres): void
    {
        $movie->genres()->attach($genres);
    }

    public function syncGenres(Movie $movie, array $genres): void
    {
        $movie->genres()->sync($genres);
    }

    public function updateAverageRating(Movie $movie): string
    {
        return $movie->rating = $movie->ratings()->average('user_rating');
    }

    public function attachPersons(Movie $movie, int $personId, array $data): void
    {
        $movie->persons()->attach([$personId => $data]);
    }

    public function isPersonExists(Movie $movie, int $personId, string $role): bool
    {
        return $movie->persons()->wherePivot('person_id', $personId)->wherePivot('role', $role)->exists();
    }

    public function delete(Movie $movie): void
    {
        $movie->delete();
    }

    public function update(Movie $movie, array $data): void
    {
        $movie->update($data);
    }

    public function getSortedMovies(string $column, string $direction): Collection
    {
        return Movie::where('is_published', '1')->orderBy($column, $direction)->get();
    }

    public function getUniqueValues(string $column): SupportCollection
    {
        return Movie::pluck($column)->unique();
    }
}
