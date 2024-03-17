<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Http\Requests\Application\CreateReviewRequest;
use App\Services\Interfaces\ReviewServiceInterface;
use Illuminate\Http\RedirectResponse;

class ReviewController extends Controller
{

    private ReviewServiceInterface $reviewService;

    public function __construct(ReviewServiceInterface $reviewService)
    {
        $this->reviewService = $reviewService;
    }

    public function createReview(CreateReviewRequest $request, $movieId)
    {
        $this->reviewService->createReview($request, $movieId);
        return redirect()->back();
    }

    public function deleteReview($commentId): RedirectResponse
    {
        $this->reviewService->deleteReview((int)$commentId);
        return redirect()->back();
    }
}
