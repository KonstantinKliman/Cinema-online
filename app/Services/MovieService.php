<?php

namespace App\Services;


use App\Enums\FilterType;
use App\Enums\SortType;
use App\Http\Requests\Application\CreateMovieRequest;
use App\Http\Requests\Application\EditMovieRequest;
use App\Http\Requests\Application\FilterMovieRequest;
use App\Models\Movie;
use App\Repositories\Interfaces\MovieRepositoryInterface;
use App\Services\Interfaces\GenreServiceInterface;
use App\Services\Interfaces\MovieServiceInterface;
use App\Services\Interfaces\PersonServiceInterface;
use App\Services\Interfaces\StorageServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\Enums\RoleType;
use Ramsey\Collection\Sort;

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

    private function processMovieFile(Movie $movie, EditMovieRequest $request): void
    {
        if ($request->hasFile('movie_file_path')) {
            $this->storageService->delete(str_replace(self::STORAGE_PATH, '', $movie->movie_file_path));
            $newMovieFilePath = $this->storageService->storeFilesForMovie($request, 'movie_file_path', $movie);
            $movie->movie_file_path = $newMovieFilePath;
            $this->movieRepository->save($movie);
        }
    }

    private function processPosterFile(Movie $movie, EditMovieRequest $request): void
    {
        if ($request->hasFile('poster_file_path')) {
            $this->storageService->delete(str_replace(self::STORAGE_PATH, '', $movie->poster_file_path));
            $newPosterFilePath = $this->storageService->storeFilesForMovie($request, 'poster_file_path', $movie);
            $movie->poster_file_path = $newPosterFilePath;
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
        $filterData = [
            FilterType::minYear->value => $request->validated(FilterType::minYear->value),
            FilterType::maxYear->value => $request->validated(FilterType::maxYear->value),
            FilterType::genres->value => $request->validated(FilterType::genres->value),
            FilterType::minRating->value => $request->validated(FilterType::minRating->value),
            FilterType::maxRating->value => $request->validated(FilterType::maxRating->value),
            FilterType::country->value => $request->validated(FilterType::country->value),
            FilterType::productionStudio->value => $request->validated(FilterType::productionStudio->value),
        ];

        $filterQuery = Movie::query();

        if ($filterData[FilterType::minYear->value] !== null && $filterData[FilterType::maxYear->value] !== null) {
            $filterQuery->whereBetween('release_year', [$filterData[FilterType::minYear->value], $filterData[FilterType::maxYear->value]]);
        }

        if ($filterData[FilterType::minRating->value] !== null && $filterData[FilterType::maxRating->value] !== null) {
            $filterQuery->whereBetween('rating', [$filterData[FilterType::minRating->value], $filterData[FilterType::maxRating->value]]);
        }

        if ($filterData[FilterType::country->value] !== null) {
            $filterQuery->where('country', $filterData[FilterType::country->value]);
        }

        if ($filterData[FilterType::productionStudio->value] !== null) {
            $filterQuery->where('production_studio', $filterData[FilterType::productionStudio->value]);
        }

        if (!empty($filterData[FilterType::genres->value])) {
            $filterQuery->whereHas('genres', function ($query) use ($filterData) {
                $query->whereIn('id', $filterData[FilterType::genres->value]);
            });
        }

        return $filterQuery->get();
    }

    public function getMovieFilePath(int $movieId): string
    {
        return $this->movieRepository->getById($movieId)->movie_file_path;
    }
}
