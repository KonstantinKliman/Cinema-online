<?php


namespace App\Services\Interfaces;

use App\Http\Requests\Dashboard\EditReviewRequest;
use App\Http\Requests\Application\CreateReviewRequest;
use App\Http\Requests\Dashboard\CreateReviewRequest as CreateReviewAdminRequest;
use App\Models\Review;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

interface ReviewServiceInterface
{
    public function createReview(CreateReviewRequest $request, int $movieId): array;

    public function deleteReview(int $reviewId): void;

    public function all(): Collection;

    public function get(int $reviewId): Review;

    public function edit(EditReviewRequest $request, bool $isPublished, int $reviewId);

    public function publish(int $reviewId);

    public function createReviewByAdmin(CreateReviewAdminRequest $request);

    public function getUserReviews(Request $request);

    public function getAllMovies(): Collection;
}
