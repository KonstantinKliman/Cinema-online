<?php


namespace App\Services;

use App\Http\Requests\Dashboard\CreateReviewRequest as CreateReviewAdminRequest;
use App\Http\Requests\Dashboard\EditReviewRequest;
use App\Http\Requests\Application\CreateReviewRequest;
use App\Models\Review;
use App\Repositories\Interfaces\MovieRepositoryInterface;
use App\Repositories\Interfaces\ReviewRepositoryInterface;
use App\Services\Interfaces\ReviewServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class ReviewService implements ReviewServiceInterface
{

    private ReviewRepositoryInterface $reviewRepository;

    private MovieRepositoryInterface $movieRepository;

    public function __construct(ReviewRepositoryInterface $reviewRepository, MovieRepositoryInterface $movieRepository)
    {
        $this->reviewRepository = $reviewRepository;
        $this->movieRepository = $movieRepository;
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

    public function deleteReview(int $reviewId): void
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
            'type_id' => $request->validated('type_id'),
            'is_published' => $request->validated('is_published'),
        ];
        $this->reviewRepository->create($data);
    }

    public function getUserReviews(Request $request)
    {
        return Review::query()->where('user_id', $request->user()->id)->get();
    }

    public function getAllMovies(): Collection
    {
        return $this->movieRepository->all();
    }
}
