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

    public function createRating(CreateRatingRequest $request): RedirectResponse
    {
        $data =
            [
                'user_id' => $request->user()->id,
                'movie_id' => $request->movie_id,
                'user_rating' => $request->validated()['rating'],
            ];

        $this->ratingService->createRating($data);

        return redirect()->back();
    }

    public function deleteRating($movieId, Request $request): RedirectResponse
    {
        $this->ratingService->deleteRating($request->user()->id, $movieId);
        return redirect()->back();
    }

}
