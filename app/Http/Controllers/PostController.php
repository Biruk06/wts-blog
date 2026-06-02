<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        // Создаем базовый запрос к таблице постов, сразу подгружая автора (без пароля)
        $query = Post::with('user:id,name');

        // Фильтрация по дате "от" (в формате YYYY-MM-DD)
        if ($request->has('date_from')) {
            $query->whereDate('created_at', '>=', $request->query('date_from'));
        }

        // Фильтрация по дате "до" (в формате YYYY-MM-DD)
        if ($request->has('date_to')) {
            $query->whereDate('created_at', '<=', $request->query('date_to'));
        }

        // Настройка сортировки
        $sortBy = $request->query('sort_by');
        $sortOrder = $request->query('sort_order', 'desc'); 
        
        
        $sortField = ($sortBy === 'title') ? 'title' : 'created_at';
        $query->orderBy($sortField, $sortOrder);

        // Пагинация
        $limit = $request->query('limit', 10); // по умолчанию 10
        $offset = $request->query('offset', 0);  // по умолчанию 0

        $posts = $query->limit($limit)->offset($offset)->get();

        return response()->json($posts, 200);
    }

    public function store(Request $request)
    {
        $fields = $request->validate([
            'title' => 'required|string|max:255',
            'text' => 'required|string',
        ]);


        $post = Post::create([
            'title' => $fields['title'],
            'text' => $fields['text'],
            'user_id' => $request->user()->id,
        ]);

        /* 
        $postData = [
            'id' => $post->id,
            'title' => $post->title,
            'created_at' => $post->created_at,
            'author' => [
                'id' => $request->user()->id,
                'name' => $request->user()->name,
            ]
        ];
        
        return response()->json($postData, 201);
        */

        return response()->json($post->load('user:id,name'), 201);
    }


    public function show(string $id)
    {
        $post = Post::with('user:id,name')->findOrFail($id);  

        return response()->json($post, 200);
    }


    public function destroy(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        
        if ($post->user_id !== $request->user()->id) {
            return response()->json([
                'message' => 'У вас нет прав на удаление этого поста'
            ], 403);
        }

        
        $post->delete();

        return response()->json([
            'message' => 'Пост успешно удален'
        ], 200);
    }
}
