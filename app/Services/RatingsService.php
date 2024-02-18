<?php


namespace App\Services;

use App\Repositories\Interfaces\RatingsRepositoryInterface;
use App\Services\Interfaces\MovieServiceInterface;
use App\Services\Interfaces\RatingsServiceInterface;

class RatingsService implements RatingsServiceInterface
{

    private RatingsRepositoryInterface $ratingsRepository;
    private MovieServiceInterface $movieService;

    public function __construct(RatingsRepositoryInterface $ratingsRepository, MovieServiceInterface $movieService)
    {
        $this->ratingsRepository = $ratingsRepository;
        $this->movieService = $movieService;
    }

    private function updateMovieRating($movieId): void
    {
        $this->movieService->updateMovieRating($movieId);
    }

    public function createRating(array $data): void
    {

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

    public function getUserRatingOnMovie($userId, $movieId): null | int
    {
        if ($this->ratingsRepository->getUserRatingOnMovie($userId, $movieId) !== null) {
            return $this->ratingsRepository->getUserRatingOnMovie($userId, $movieId)->user_rating;
        }

        return null;
    }

}
