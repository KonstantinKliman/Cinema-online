<?php


namespace App\Repositories;

use App\Models\Review;
use App\Repositories\Interfaces\ReviewRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ReviewRepository implements ReviewRepositoryInterface
{
    public function create(array $data): Review
    {
        return Review::create($data);
    }

    public function get(int $reviewId): Review
    {
        return Review::find($reviewId);
    }

    public function delete(int $reviewId): void
    {
        Review::destroy($reviewId);
    }

    public function all(): Collection
    {
        return Review::all();
    }

    public function edit(array $data, int $reviewId)
    {
        Review::find($reviewId)->update($data);
    }

    public function publish(int $reviewId)
    {
        Review::find($reviewId)->update(['is_pu']);
    }

    public function save(Review $review)
    {
        $review->save();
    }
}
