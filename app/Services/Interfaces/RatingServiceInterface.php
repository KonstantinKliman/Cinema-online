<?php


namespace App\Services\Interfaces;


use App\Http\Requests\Application\CreateRatingRequest;
use Illuminate\Http\Request;

interface RatingServiceInterface
{
    public function createRating(CreateRatingRequest $request, $movieId);

    public function getUserRatingOnMovie(int $userId, int $movieId);

    public function deleteRating(int $userId, int $movieId);

    public function getRatingsForUser(Request $request);
}
