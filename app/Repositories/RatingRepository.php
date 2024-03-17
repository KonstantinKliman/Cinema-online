<?php


namespace App\Repositories;


use App\Models\Rating;
use App\Repositories\Interfaces\RatingRepositoryInterface;

class RatingRepository implements RatingRepositoryInterface
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


    public function delete(int $userId, int $movieId): bool
    {
        return Rating::where(['user_id' => $userId, 'movie_id' => $movieId])->delete();
    }

}
