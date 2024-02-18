<?php


namespace App\Repositories\Interfaces;


interface RatingsRepositoryInterface
{
    public function firstOrNew(int $userId, int $movieId);
    public function create(array $data);
}
