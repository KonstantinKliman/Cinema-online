<?php


namespace App\Repositories\Interfaces;

interface ProfileRepositoryInterface
{
    public function getByUserId(int $userId);

    public function create(int $userId);
}
