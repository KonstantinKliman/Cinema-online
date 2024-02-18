<?php


namespace App\Repositories\Interfaces;

use App\Models\Comment;

interface CommentRepositoryInterface
{

    public function create(array $data): Comment;

    public function find(int $commentId);

    public function delete(Comment $comment): void;

}
