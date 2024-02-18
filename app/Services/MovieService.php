<?php

namespace App\Services;


use App\Http\Requests\Application\CreateMovieRequest;
use App\Http\Requests\Application\EditMovieRequest;
use App\Http\Requests\Application\SortMovieRequest;
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

    public function __construct(MovieRepositoryInterface $movieRepository, GenreServiceInterface $genreService, PersonServiceInterface $personService, StorageServiceInterface $storageService)
    {
        $this->movieRepository = $movieRepository;
        $this->genreService = $genreService;
        $this->personService = $personService;
        $this->storageService = $storageService;
    }

    private function isMovieExists(string $requestMovieTitle): bool
    {
        return $this->movieRepository->getByTitle($requestMovieTitle) !== null;
    }

    public function createMovie(CreateMovieRequest $request): array
    {
        if (!$this->isMovieExists($request->validated('title'))) {
            $data = [
                'user_id' => $request->user()->id,
                'title' => $request->validated('title'),
                'country' => $request->validated('country'),
                'production_studio' => $request->validated('production_studio'),
                'release_year' => $request->validated('release_year'),
                'description' => $request->validated('description'),
                'movie_file_path' => 'storage/' . $request->file('movie_file_path')->store('movies/' . $request->validated('title')),
                'poster_file_path' => 'storage/' . $request->file('poster_file_path')->store('movies/' . $request->validated('title')),
            ];

            $genres = $request->validated('genres');
            $movie = $this->movieRepository->create($data);
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

        $oldMovieTitle = $movie->title;
        $oldMovieFilePath = str_replace('storage/', '', $movie->movie_file_path);
        $oldPosterFilePath = str_replace('storage/', '', $movie->poster_file_path);

        $this->movieRepository->update($movie, $request->validated());
        // Если у фильма изменился только title
        if ($movie->wasChanged('title') && !$request->hasFile('movie_file_path') && !$request->hasFile('poster_file_path')) {
            $oldMovieDirectory = 'movies/' . $oldMovieTitle;
            $movie->poster_file_path = str_replace($oldMovieTitle, $movie->title, $movie->poster_file_path);
            $movie->movie_file_path = str_replace($oldMovieTitle, $movie->title, $movie->movie_file_path);
            $this->storageService->move($oldMovieFilePath, str_replace('storage/', '', $movie->movie_file_path));
            $this->storageService->move($oldPosterFilePath, str_replace('storage/', '', $movie->poster_file_path));
            $this->storageService->deleteDirectory($oldMovieDirectory);
            $this->movieRepository->save($movie);
        }
        // Если у фильма изменился title и был загружен новый файл с фильмом
        if ($movie->wasChanged('title') && $request->hasFile('movie_file_path') && !$request->hasFile('poster_file_path')) {
            $this->storageService->delete($oldMovieFilePath);
            $oldMovieDirectory = 'movies/' . $oldMovieTitle;
            $newMovieFilePath = 'storage/' . $request->file('movie_file_path')->store('movies/' . $request->validated('title'));
            $newPosterFilePath = str_replace($oldMovieTitle, $movie->title, $movie->poster_file_path);
            $movie->movie_file_path = $newMovieFilePath;
            $movie->poster_file_path = $newPosterFilePath;
            $this->storageService->move($oldPosterFilePath, str_replace('storage/', '', $newPosterFilePath));
            $this->storageService->deleteDirectory($oldMovieDirectory);
            $this->movieRepository->save($movie);
        }
        // Если у фильма изменился title и был загружен новый файл с постером
        if ($movie->wasChanged('title') && !$request->hasFile('movie_file_path') && $request->hasFile('poster_file_path')) {
            $this->storageService->delete($oldPosterFilePath);
            $oldMovieDirectory = 'movies/' . $oldMovieTitle;
            $newPosterFilePath = 'storage/' . $request->file('poster_file_path')->store('movies/' . $request->validated('title'));
            $newMovieFilePath = str_replace($oldMovieTitle, $movie->title, $movie->movie_file_path);
            $movie->movie_file_path = $newMovieFilePath;
            $movie->poster_file_path = $newPosterFilePath;
            $this->storageService->move($oldMovieFilePath, str_replace('storage/', '', $newMovieFilePath));
            $this->storageService->deleteDirectory($oldMovieDirectory);
            $this->movieRepository->save($movie);
        }
        // Если у фильма изменился title и был загружен новый файл с фильмом и новый файл с постером
        if ($movie->wasChanged('title') && $request->hasFile('poster_file_path') && $request->hasFile('movie_file_path')) {
            $oldMovieDirectory = 'movies/' . $oldMovieTitle;
            $newMovieFilePath = 'storage/' . $request->file('movie_file_path')->store('movies/' . $request->validated('title'));
            $newPosterFilePath = 'storage/' . $request->file('poster_file_path')->store('movies/' . $request->validated('title'));
            $movie->movie_file_path = $newMovieFilePath;
            $movie->poster_file_path = $newPosterFilePath;
            $this->storageService->delete([$oldMovieFilePath, $oldPosterFilePath]);
            if ($request->validated('title') !== $movie->title) {
                $this->storageService->deleteDirectory($oldMovieDirectory);
            }
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
