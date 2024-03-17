<?php


namespace App\Services\Interfaces;

use App\Http\Requests\Admin\EditReviewRequest;
use App\Http\Requests\Application\CreateReviewRequest;
use App\Models\Review;
use Illuminate\Database\Eloquent\Collection;

interface ReviewServiceInterface
{
    public function createReview(CreateReviewRequest $request, int $movieId): array;

    public function delete(int $reviewId): void;

    public function all(): Collection;

    public function get(int $reviewId): Review;

    public function edit(EditReviewRequest $request, bool $isPublished, int $reviewId);

    public function publish(int $reviewId);
}
