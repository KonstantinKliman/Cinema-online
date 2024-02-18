<?php


namespace App\Repositories;

use App\Models\Comment;
use App\Repositories\Interfaces\CommentRepositoryInterface;

class CommentRepository implements CommentRepositoryInterface
{
    public function create(array $data): Comment
    {
        return Comment::create($data);
    }

    public function find(int $commentId): Comment
    {
        return Comment::find($commentId);
    }

    public function delete(Comment $comment): void
    {
        $comment->delete();
    }
}
