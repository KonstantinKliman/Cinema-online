<?php

namespace App\Services;


use App\Http\Requests\Application\CreateMovieRequest;
use App\Http\Requests\Application\EditMovieRequest;
use App\Models\Movie;
use App\Repositories\Interfaces\MovieRepositoryInterface;
use App\Services\Interfaces\GenreServiceInterface;
use App\Services\Interfaces\MovieServiceInterface;
use App\Services\Interfaces\PersonServiceInterface;
use App\Services\Interfaces\StorageServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class MovieService implements MovieServiceInterface
{

    private MovieRepositoryInterface $movieRepository;
    private GenreServiceInterface $genreService;
    private PersonServiceInterface $personService;
    private StorageServiceInterface $storageService;

    private const STORAGE_PATH = 'storage/';
    private const MOVIE_PATH = 'movies/';

    public function __construct(MovieRepositoryInterface $movieRepository, GenreServiceInterface $genreService, PersonServiceInterface $personService, StorageServiceInterface $storageService)
    {
        $this->movieRepository = $movieRepository;
        $this->genreService = $genreService;
        $this->personService = $personService;
        $this->storageService = $storageService;
    }

    public function createMovie(CreateMovieRequest $request): array
    {
        if (!$this->isMovieExists($request->validated('title'))) {
            $movie = $this->movieRepository->create([
                'user_id' => $request->user()->id,
                'title' => $request->validated('title'),
                'country' => $request->validated('country'),
                'production_studio' => $request->validated('production_studio'),
                'release_year' => $request->validated('release_year'),
                'description' => $request->validated('description'),
                'movie_file_path' => null,
                'poster_file_path' => null,
            ]);
            $movie->movie_file_path = self::STORAGE_PATH . $request->file('movie_file_path')->store(self::MOVIE_PATH . $movie->id);
            $movie->poster_file_path = self::STORAGE_PATH . $request->file('poster_file_path')->store(self::MOVIE_PATH . $movie->id);
            $this->movieRepository->save($movie);
            $genres = $request->validated('genres');
            $this->genreService->createGenreForMovie($movie, $genres);

            return ['create_movie_success' => 'Movie "' . $movie->title . '" uploaded.'];
        }
        return ['create_movie_error' => 'Movie "' . $request->validated('title') . '" already exists.'];
    }

    public function getMovieItem(int $movieId): Movie
    {
        return $this->movieRepository->getById($movieId);
    }

    public function searchMovie(string $query): Collection
    {
        return $this->movieRepository->getCollectionByQuery($query);
    }

    public function updateMovieRating(int $movieId): void
    {
        $movie = $this->movieRepository->getById($movieId);
        $this->movieRepository->updateAverageRating($movie);
        $this->movieRepository->save($movie);
    }

    public function paginate(int $moviesPerView)
    {
        return $this->movieRepository->paginate($moviesPerView);
    }

    public function all()
    {
        return $this->movieRepository->all();
    }

    public function getPersonOnMovie(int $movieId, Request $request): array
    {
        $movie = $this->movieRepository->getById($movieId);

        $personsOnMovie = $movie->persons;

        $persons = [];
        foreach ($personsOnMovie as $person) {
            $role = $person->pivot->role;
            $fullName = $person->full_name;

            if (!isset($persons[$role])) {
                $persons[$role] = [];
            }

            $persons[$role][] = $this->personService->getPersonByFullName($fullName);
        }

        return $persons;

    }

    public function edit(int $movieId, EditMovieRequest $request): Movie
    {
        $movie = $this->movieRepository->getById($movieId);
        $this->movieRepository->update($movie, [
            'title' => $request->validated('title'),
            'country' => $request->validated('country'),
            'production_studio' => $request->validated('production_studio'),
            'release_year' => $request->validated('release_year'),
            'description' => $request->validated('description'),
        ]);
        $oldMovieFilePath = str_replace(self::STORAGE_PATH, '', $movie->movie_file_path);
        $oldPosterFilePath = str_replace(self::STORAGE_PATH, '', $movie->poster_file_path);
        // Если измеился файл фильма
        if ($request->hasFile('movie_file_path') && !$request->hasFile('poster_file_path')) {
            $this->storageService->delete($oldMovieFilePath);
            $newMovieFilePath = self::STORAGE_PATH . $request->file('movie_file_path')->store(self::MOVIE_PATH . $movie->id);
            $movie->movie_file_path = $newMovieFilePath;
            $this->movieRepository->save($movie);
        }
        // Если измеился файл постера
        if (!$request->hasFile('movie_file_path') && $request->hasFile('poster_file_path')) {
            $this->storageService->delete($oldPosterFilePath);
            $newPosterFilePath = self::STORAGE_PATH . $request->file('poster_file_path')->store(self::MOVIE_PATH . $movie->id);
            $movie->poster_file_path = $newPosterFilePath;
            $this->movieRepository->save($movie);
        }
        // Если измеился файл фильма и файл постера
        if ($request->hasFile('movie_file_path') && $request->hasFile('poster_file_path')) {
            $this->storageService->delete([$oldMovieFilePath, $oldPosterFilePath]);
            $newMovieFilePath = self::STORAGE_PATH . $request->file('movie_file_path')->store(self::MOVIE_PATH . $movie->id);
            $newPosterFilePath = self::STORAGE_PATH . $request->file('poster_file_path')->store(self::MOVIE_PATH . $movie->id);
            $movie->movie_file_path = $newMovieFilePath;
            $movie->poster_file_path = $newPosterFilePath;
            $this->movieRepository->save($movie);
        }
        $this->movieRepository->syncGenres($movie, $request->validated('genres'));

        return $movie;
    }

    public function delete(int $movieId): void
    {
        $movie = $this->movieRepository->getById($movieId);
        $this->movieRepository->delete($movie);
    }

    public function publish(int $movieId): void
    {
        $movie = $this->movieRepository->getById($movieId);
        $movie->is_published = !$movie->is_published;
        $this->movieRepository->save($movie);
    }

    public function sort(string $sortQuery): Collection
    {
        return match ($sortQuery) {
            'desc' => $this->movieRepository->getSortedMovies('title', 'desc'),
            'asc' => $this->movieRepository->getSortedMovies('title', 'asc'),
            'newest_upload' => $this->movieRepository->getSortedMovies('created_at', 'desc'),
            'oldest_upload' => $this->movieRepository->getSortedMovies('created_at', 'asc'),
            'best_rating' => $this->movieRepository->getSortedMovies('rating', 'desc'),
            'worst_rating' => $this->movieRepository->getSortedMovies('rating', 'asc'),
            'newest_release_year' => $this->movieRepository->getSortedMovies('release_year', 'desc'),
            'oldest_release_year' => $this->movieRepository->getSortedMovies('release_year', 'asc'),
        };
    }
}
