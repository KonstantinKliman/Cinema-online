<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Http\Requests\Application\CreateRatingRequest;
use App\Models\Rating;
use App\Services\Interfaces\RatingServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

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

}
