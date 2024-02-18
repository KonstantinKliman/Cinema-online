<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Http\Requests\Application\CreateCommentRequest;
use App\Services\Interfaces\CommentServiceInterface;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    private CommentServiceInterface $commentService;

    public function __construct(CommentServiceInterface $commentService)
    {
        $this->commentService = $commentService;
    }

    public function createComment(CreateCommentRequest $request, $movieId)
    {
        return redirect()->back()->with($this->commentService->createComment($request, $movieId));
    }

    public function deleteComment($commentId)
    {
        $this->commentService->deleteComment((int)$commentId);
        return redirect()->back();
    }
}
