<?php


namespace App\Services\Interfaces;

use App\Http\Requests\Application\CreateCommentRequest;

interface CommentServiceInterface
{
    public function createComment(CreateCommentRequest $request, int $movieId): array;
    public function deleteComment(int $commentId);
}
