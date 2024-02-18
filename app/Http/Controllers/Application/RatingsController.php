<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Http\Requests\Application\CreateRatingRequest;
use App\Services\Interfaces\RatingsServiceInterface;
use Illuminate\Http\RedirectResponse;

class RatingsController extends Controller
{

    private RatingsServiceInterface $ratingService;

    public function __construct(RatingsServiceInterface $ratingService)
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

}
