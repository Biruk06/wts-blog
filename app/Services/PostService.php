<?php

namespace App\Services;

use App\Models\Post;
use App\Models\User;

class PostService
{
    public function getFilteredPosts(array $filters)
    {
        $query = Post::with('user:id,name');

        if (!empty($filters['date_from'])) {
            $query->whereDate('created_at', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $query->whereDate('created_at', '<=', $filters['date_to']);
        }

        $sortBy = $filters['sort_by'] ?? 'created_at';
        $sortOrder = $filters['sort_order'] ?? 'desc';

        $query->orderBy($sortBy, $sortOrder);

        $limit = $filters['limit'] ?? 10;
        $offset = $filters['offset'] ?? 0;

        return $query->skip($offset)->take($limit)->get();
    }

    public function createPost(User $user, array $data): Post
    {
        return $user->posts()->create($data);
    }

    public function deletePost(Post $post, User $user): bool
    {
        if ($post->user_id !== $user->id) {
            abort(403, 'У вас нет прав на удаление этой публикации');
        }

        return $post->delete();
    }

    public function getUserPosts(User $user)
    {
        return $user->posts()
            ->with('user:id,name')
            ->latest()
            ->get();
    }

    public function getPost(Post $post): Post
    {
        return $post->load('user:id,name');
    }
}