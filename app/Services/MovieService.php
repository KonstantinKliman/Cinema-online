<?php

namespace App\Services;


use App\Enums\SortType;
use App\Http\Requests\Application\CreateMovieRequest;
use App\Http\Requests\Application\EditMovieRequest;
use App\Http\Requests\Application\FilterMovieRequest;
use App\Models\Movie;
use App\Repositories\Interfaces\GenreRepositoryInterface;
use App\Repositories\Interfaces\MovieRepositoryInterface;
use App\Repositories\Interfaces\PersonRepositoryInterface;
use App\Repositories\Interfaces\RatingRepositoryInterface;
use App\Services\Interfaces\MovieServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MovieService implements MovieServiceInterface
{

    private MovieRepositoryInterface $movieRepository;
    private RatingRepositoryInterface $ratingRepository;
    private PersonRepositoryInterface $personRepository;
    private GenreRepositoryInterface $genreRepository;
    private const STORAGE_PATH = 'storage/';
    private const MOVIE_PATH = 'movies/';

    public function __construct(MovieRepositoryInterface $movieRepository, RatingRepositoryInterface $ratingRepository, PersonRepositoryInterface $personRepository, GenreRepositoryInterface $genreRepository)
    {
        $this->movieRepository = $movieRepository;
        $this->ratingRepository = $ratingRepository;
        $this->personRepository = $personRepository;
        $this->genreRepository = $genreRepository;
    }

    public function createMovie(CreateMovieRequest $request): array
    {
        if ($this->movieRepository->getByTitle($request->validated('title')) == null) {
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
            $this->movieRepository->attachGenres($movie, $genres);

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

            $persons[$role][] = $this->personRepository->getByFullName($fullName);;
        }

        return $persons;

    }

    private function processMovieFile(Movie $movie, EditMovieRequest $request): void
    {
        if ($request->hasFile('movie_file_path')) {
            Storage::delete(str_replace(self::STORAGE_PATH, '', $movie->movie_file_path));
            $movie->movie_file_path = self::STORAGE_PATH . $request->file('movie_file_path')->store(self::MOVIE_PATH . $movie->id);
            $this->movieRepository->save($movie);
        }
    }

    private function processPosterFile(Movie $movie, EditMovieRequest $request): void
    {
        if ($request->hasFile('poster_file_path')) {
            Storage::delete(str_replace(self::STORAGE_PATH, '', $movie->poster_file_path));
            $movie->poster_file_path = self::STORAGE_PATH . $request->file('poster_file_path')->store(self::MOVIE_PATH . $movie->id);
            $this->movieRepository->save($movie);
        }
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
        $this->processMovieFile($movie, $request);
        $this->processPosterFile($movie, $request);
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
            SortType::desc->value => $this->movieRepository->getSortedMovies('title', 'desc'),
            SortType::asc->value => $this->movieRepository->getSortedMovies('title', 'asc'),
            SortType::newestUpload->value => $this->movieRepository->getSortedMovies('created_at', 'desc'),
            SortType::oldestUpload->value => $this->movieRepository->getSortedMovies('created_at', 'asc'),
            SortType::bestRating->value => $this->movieRepository->getSortedMovies('rating', 'desc'),
            SortType::worstRating->value => $this->movieRepository->getSortedMovies('rating', 'asc'),
            SortType::newestReleaseYear->value => $this->movieRepository->getSortedMovies('release_year', 'desc'),
            SortType::oldestReleaseYear->value => $this->movieRepository->getSortedMovies('release_year', 'asc'),
        };
    }

    public function getFilterData()
    {
        $uniqueProductionStudios = $this->movieRepository->getUniqueValues('production_studio');
        $uniqueCountries = $this->movieRepository->getUniqueValues('country');
        return [
            'productionStudios' => $uniqueProductionStudios,
            'countries' => $uniqueCountries
        ];
    }

    public function filter(FilterMovieRequest $request): Collection
    {
        $filterData = array_filter([
            'min_year' => $request->validated('min_year'),
            'max_year' => $request->validated('max_year'),
            'genres' => $request->validated('genres'),
            'min_rating' => $request->validated('min_rating'),
            'max_rating' => $request->validated('max_rating'),
            'country' => $request->validated('country'),
            'production_studio' => $request->validated('production_studio'),
        ]);

        $filterQuery = Movie::query();

        if ($filterData['min_year'] !== null && $filterData['max_year'] !== null) {
            $filterQuery->whereBetween('release_year', [$filterData['min_year'], $filterData['max_year']]);
        }

        if ($filterData['min_rating'] !== null && $filterData['max_rating'] !== null) {
            $filterQuery->whereBetween('rating', [$filterData['min_rating'], $filterData['max_rating']]);
        }

        if ($filterData['country'] !== null) {
            $filterQuery->where('country', $filterData['country']);
        }

        if ($filterData['production_studio'] !== null) {
            $filterQuery->where('production_studio', $filterData['production_studio']);
        }

        if (!empty($filterData['genres'])) {
            $filterQuery->whereHas('genres', function ($query) use ($filterData) {
                $query->whereIn('id', $filterData['genres']);
            });
        }

        return $filterQuery->get();
    }

    public function getMovieFilePath(int $movieId): string
    {
        return $this->movieRepository->getById($movieId)->movie_file_path;
    }

    public function getUserRatingOnMovie(int $userId, int $movieId): int|null
    {
        if ($this->ratingRepository->getUserRatingOnMovie($userId, $movieId) !== null) {
            return $this->ratingRepository->getUserRatingOnMovie($userId, $movieId)->user_rating;
        }

        return null;
    }

    public function getAllGenres()
    {
        return $this->genreRepository->all();
    }
}
