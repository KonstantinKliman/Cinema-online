<?php


namespace App\Repositories\Interfaces;


interface RatingRepositoryInterface
{
    public function firstOrNew(int $userId, int $movieId);
    public function create(array $data);
    public function delete(int $userId, int $movieId): bool;
}
