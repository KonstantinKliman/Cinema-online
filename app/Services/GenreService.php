<?php


namespace App\Services;


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

    public function getMoviesByGenreName(string $genreName)
    {
        $genre = $this->genreRepository->findByGenreName($genreName);
        $movies = $genre->movies;
        return $movies;
    }

    public function getGenreByName(string $genreName)
    {
        return $this->genreRepository->findByGenreName($genreName);
    }

    public function getAllGenres(): Collection
    {
        return $this->genreRepository->all();
    }
}
