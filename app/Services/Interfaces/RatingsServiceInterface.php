<?php


namespace App\Services\Interfaces;


interface RatingsServiceInterface
{
    public function createRating(array $data);
    public function getUserRatingOnMovie($userId, $movieId);
}
