<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Http\Requests\Application\CreateRatingRequest;
use App\Models\Rating;
use App\Services\Interfaces\RatingServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RatingController extends Controller
{

    private RatingServiceInterface $ratingService;

    public function __construct(RatingServiceInterface $ratingService)
    {
        $this->ratingService = $ratingService;
    }

    public function createRating(CreateRatingRequest $request, $movieId): RedirectResponse
    {
        $this->ratingService->createRating($request, $movieId);
        return redirect()->back();
    }

    public function deleteRating($movieId, Request $request): RedirectResponse
    {
        $this->ratingService->deleteRating($request->user()->id, $movieId);
        return redirect()->back();
    }

    public function index(Request $request): View
    {
        return view('rating.index', ['ratings' => $this->ratingService->getRatingsForUser($request)]);
    }

}
