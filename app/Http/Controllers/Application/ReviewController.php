<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\EditReviewRequest;
use App\Http\Requests\Application\CreateReviewRequest;
use App\Http\Requests\Dashboard\CreateReviewRequest as CreateAdminReviewRequest;
use App\Services\Interfaces\MovieServiceInterface;
use App\Services\Interfaces\ReviewServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReviewController extends Controller
{

    private ReviewServiceInterface $reviewService;

    public function __construct(ReviewServiceInterface $reviewService)
    {
        $this->reviewService = $reviewService;
    }

    public function deleteReview($commentId): RedirectResponse
    {
        $this->reviewService->deleteReview((int)$commentId);
        return redirect()->back();
    }

    public function createReview(CreateReviewRequest $request, $movieId) //
    {
        $this->reviewService->createReview($request, $movieId);
        return redirect()->back();
    }

    public function index(Request $request): View
    {
        return view('review.index', ['reviews' => $this->reviewService->getUserReviews($request)]);
    }

    public function adminIndex(): View
    {
        return view('dashboard.review.index', ['reviews' => $this->reviewService->all()]);
    }

    public function create(): View
    {
        return view('dashboard.review.create', ['movies' => $this->reviewService->getAllMovies()]);
    }

    public function adminStore(CreateAdminReviewRequest $request): RedirectResponse
    {
        $this->reviewService->createReviewByAdmin($request);
        return redirect()->route('dashboard.review.index');
    }

    public function show($reviewId): View
    {
        return view('dashboard.review.show', ['review' => $this->reviewService->get($reviewId)]);
    }

    public function edit($reviewId): View
    {
        return view('dashboard.review.edit', ['review' => $this->reviewService->get($reviewId)]);
    }

    public function update(EditReviewRequest $request, $reviewId): RedirectResponse
    {
        $isPublished = (bool)$request->is_published;
        $this->reviewService->edit($request, $isPublished, $reviewId);
        return redirect()->back();
    }

    public function delete($reviewId): RedirectResponse
    {
        $this->reviewService->deleteReview($reviewId);
        return redirect()->route('dashboard.review.index');
    }

    public function publish($reviewId): RedirectResponse
    {
        $this->reviewService->publish($reviewId);
        return redirect()->back();
    }
}
