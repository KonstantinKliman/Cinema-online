<?php


namespace App\Services;

use App\Http\Requests\Application\CreateRatingRequest;
use App\Models\Rating;
use App\Repositories\Interfaces\RatingRepositoryInterface;
use App\Services\Interfaces\MovieServiceInterface;
use App\Services\Interfaces\RatingServiceInterface;

class RatingService implements RatingServiceInterface
{

    private RatingRepositoryInterface $ratingsRepository;
    private MovieServiceInterface $movieService;

    public function __construct(RatingRepositoryInterface $ratingsRepository, MovieServiceInterface $movieService)
    {
        $this->ratingsRepository = $ratingsRepository;
        $this->movieService = $movieService;
    }

    private function updateMovieRating($movieId): void
    {
        $this->movieService->updateMovieRating($movieId);
    }

    public function createRating(CreateRatingRequest $request, $movieId): void
    {
        $data = [
            'user_id' => $request->user()->id,
            'movie_id' => $movieId,
            'user_rating' => $request->validated('rating')
        ];

        $rating = $this->ratingsRepository->firstOrNew($data['user_id'], $data['movie_id']);

        if ($rating->exists) {
            if ($rating->user_rating !== $data['user_rating']) {
                $rating->user_rating = $data['user_rating'];
                $rating->save();
                $this->updateMovieRating($data['movie_id']);
            }
        } else {
            $this->ratingsRepository->create($data);
            $this->updateMovieRating($data['movie_id']);
        }

    }

    public function getUserRatingOnMovie(int $userId, int $movieId): null | int
    {
        if ($this->ratingsRepository->getUserRatingOnMovie($userId, $movieId) !== null) {
            return $this->ratingsRepository->getUserRatingOnMovie($userId, $movieId)->user_rating;
        }

        return null;
    }

    public function deleteRating(int $userId, int $movieId): bool
    {
       return $this->ratingsRepository->delete($userId, $movieId);
    }
}
