<?php


namespace App\Services;

use App\Http\Requests\Application\CreateCommentRequest;
use App\Models\Comment;
use App\Models\Movie;
use App\Repositories\Interfaces\CommentRepositoryInterface;
use App\Services\Interfaces\CommentServiceInterface;

class CommentService implements CommentServiceInterface
{

    private CommentRepositoryInterface $commentRepository;

    public function __construct(CommentRepositoryInterface $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function createComment(CreateCommentRequest $request, int $movieId): array
    {
        $data = [
            'user_id' => $request->user()->id,
            'movie_id' => $movieId,
            'content' => $request->validated('content'),
        ];

        $this->commentRepository->create($data);

        return ['create_comment_success' => 'Comment posted.'];
    }

    public function deleteComment(int $commentId)
    {
        $comment = $this->commentRepository->find($commentId);
        if ($comment) {
            $this->commentRepository->delete($comment);
        }
    }
}
