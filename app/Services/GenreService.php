<?php


namespace App\Services;


use App\Http\Requests\Admin\EditGenreRequest;
use App\Http\Requests\Application\CreateGenreRequest;
use App\Models\Genre;
use App\Models\Movie;
use App\Repositories\Interfaces\GenreRepositoryInterface;
use App\Repositories\Interfaces\MovieRepositoryInterface;
use App\Services\Interfaces\GenreServiceInterface;
use Illuminate\Database\Eloquent\Collection;

class GenreService implements GenreServiceInterface
{

    private GenreRepositoryInterface $genreRepository;
    private MovieRepositoryInterface $movieRepository;

    public function __construct(GenreRepositoryInterface $genreRepository, MovieRepositoryInterface $movieRepository)
    {
        $this->genreRepository = $genreRepository;
        $this->movieRepository = $movieRepository;
    }

    public function createGenreForMovie(Movie $movie, array $genres)
    {
        return $this->movieRepository->attachGenres($movie, $genres);
    }

    public function getMoviesByGenre(Genre $genre)
    {
        return $genre->movies;
    }

    public function getAllGenres(): Collection
    {
        return $this->genreRepository->all();
    }

    public function detach(int $genreId, int $movieId)
    {
        $movie = $this->movieRepository->getById($movieId);
        $this->genreRepository->detach($movie, $genreId);
    }

    public function create(CreateGenreRequest $request)
    {
        $data = [
            'name' => $request->validated('name'),
            'description' => $request->validated('description'),
            'slug' => strtolower(str_replace([' ', '.'], ['-', ''],    $request->validated('name'))),
        ];
        return $this->genreRepository->create($data);
    }

    public function edit(EditGenreRequest $request, Genre $genre): string
    {
        $data = [
            'name' => $request->validated('name'),
            'description' => $request->validated('description'),
            'slug' => strtolower(str_replace([' ', '.'], ['-', ''],    $request->validated('name'))),
        ];
        $this->genreRepository->update($data, $genre);
        return $genre->slug;
    }

    public function delete(Genre $genre): void
    {
        $this->genreRepository->delete($genre);
    }
}
