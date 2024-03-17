<?php


namespace App\Repositories\Interfaces;

use App\Models\Review;
use Illuminate\Database\Eloquent\Collection;

interface ReviewRepositoryInterface
{

    public function create(array $data): Review;

    public function get(int $reviewId);

    public function delete(int $reviewId): void;

    public function all(): Collection;

    public function edit(array $data, int $reviewId);

    public function publish(int $reviewId);

    public function save(Review $review);
}
