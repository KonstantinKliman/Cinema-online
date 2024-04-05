<?php


namespace App\Services;

use App\Http\Requests\Admin\CreateReviewRequest as CreateReviewAdminRequest;
use App\Http\Requests\Admin\EditReviewRequest;
use App\Http\Requests\Application\CreateReviewRequest;
use App\Models\Review;
use App\Repositories\Interfaces\ReviewRepositoryInterface;
use App\Services\Interfaces\ReviewServiceInterface;
use Illuminate\Database\Eloquent\Collection;

class ReviewService implements ReviewServiceInterface
{

    private ReviewRepositoryInterface $reviewRepository;

    public function __construct(ReviewRepositoryInterface $reviewRepository)
    {
        $this->reviewRepository = $reviewRepository;
    }

    public function createReview(CreateReviewRequest $request, int $movieId): array
    {
        $data = [
            'user_id' => $request->user()->id,
            'movie_id' => $movieId,
            'title' => $request->validated('title'),
            'review' => $request->validated('review'),
            'type' => $request->validated('type'),
            'is_published' => false
        ];

        $review = $this->reviewRepository->create($data);

        return ['create_review_success' => 'Review posted.'];
    }

    public function delete(int $reviewId): void
    {
        $this->reviewRepository->delete($reviewId);
    }

    public function all(): Collection
    {
        return $this->reviewRepository->all();
    }

    public function get(int $reviewId): Review
    {
        return $this->reviewRepository->get($reviewId);
    }

    public function edit(EditReviewRequest $request, bool $isPublished, int $reviewId)
    {
        $data = [
            'title' => $request->validated('title'),
            'review' => $request->validated('review'),
            'type' => $request->validated('type'),
            'is_published' => $isPublished,
        ];

        $this->reviewRepository->edit($data, $reviewId);
    }

    public function publish(int $reviewId)
    {
        $review = $this->reviewRepository->get($reviewId);
        $review->is_published = !$review->is_published;
        $this->reviewRepository->save($review);
    }

    public function createReviewByAdmin(CreateReviewAdminRequest $request)
    {
        $data = [
            'movie_id' => $request->validated('movie_id'),
            'user_id' => $request->user()->id,
            'title' => $request->validated('title'),
            'review' => $request->validated('review'),
            'type' => $request->validated('type'),
            'is_published' => $request->validated('is_published'),
        ];
        $this->reviewRepository->create($data);
    }
}
