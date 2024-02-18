<?php


namespace App\Repositories;


use App\Models\Rating;
use App\Repositories\Interfaces\RatingsRepositoryInterface;

class RatingsRepository implements RatingsRepositoryInterface
{

    public function firstOrNew(int $userId, int $movieId)
    {
        return Rating::firstOrNew(['user_id' => $userId, 'movie_id' => $movieId]);
    }

    public function create(array $data)
    {
        return Rating::create($data);
    }

    public function getUserRatingOnMovie(int $userId, int $movieId)
    {
        return Rating::where(['user_id' => $userId, 'movie_id' => $movieId])->first();
    }
}
