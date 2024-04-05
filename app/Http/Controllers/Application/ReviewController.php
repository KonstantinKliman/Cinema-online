<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EditReviewRequest;
use App\Http\Requests\Application\CreateReviewRequest;
use App\Http\Requests\Admin\CreateReviewRequest as CreateAdminReviewRequest;
use App\Services\Interfaces\MovieServiceInterface;
use App\Services\Interfaces\ReviewServiceInterface;
use Illuminate\Http\RedirectResponse;

class ReviewController extends Controller
{

    private ReviewServiceInterface $reviewService;

    private MovieServiceInterface $movieService;
    public function __construct(ReviewServiceInterface $reviewService, MovieServiceInterface $movieService)
    {
        $this->reviewService = $reviewService;
        $this->movieService = $movieService;
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

    public function index()
    {
        return view('admin.review.index', ['reviews' => $this->reviewService->all()]);
    }

    public function create()
    {
        return view('admin.review.create', ['movies' => $this->movieService->all()]);
    }

    public function adminStore(CreateAdminReviewRequest $request)
    {
        $this->reviewService->createReviewByAdmin($request);
        return redirect()->route('admin.review.index');
    }

    public function show($reviewId)
    {
        return view('admin.review.show', ['review' => $this->reviewService->get($reviewId)]);
    }

    public function edit($reviewId)
    {
        return view('admin.review.edit', ['review' => $this->reviewService->get($reviewId)]);
    }

    public function update(EditReviewRequest $request, $reviewId)
    {
        $isPublished = (bool)$request->is_published;
        $this->reviewService->edit($request, $isPublished, $reviewId);
        return redirect()->back();
    }

    public function delete($reviewId)
    {
        $this->reviewService->delete($reviewId);
        return redirect()->route('admin.review.index');
    }

    public function publish($reviewId)
    {
        $this->reviewService->publish($reviewId);
        return redirect()->back();
    }
}
