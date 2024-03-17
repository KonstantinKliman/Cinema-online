<?php


namespace App\Services\Interfaces;


interface RatingServiceInterface
{
    public function createRating(array $data);
    public function getUserRatingOnMovie(int $userId, int $movieId);

    public function deleteRating(int $userId, int $movieId);
}
