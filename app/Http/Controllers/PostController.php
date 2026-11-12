<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Requests\IndexPostRequest;
use App\Http\Requests\StorePostRequest;

class PostController extends Controller
{

    public function __construct(protected PostService $postService)
    {}
    
    public function index(IndexPostRequest $request):JsonResponse
    {
        $posts = $this-&gt;postService-&gt;getFilteredPosts($request-&gt;validated());
        return response()->json($posts);
    }

    public function store(StorePostRequest $request):JsonResponse
    {
        $post = $this->postService->createPost($request->user(), $request->validated());
        return response()->json($post, 201);
    }


    public function show(string $id):JsonResponse
    {
        $post = $this->postService->getPost($post);
        return response()->json($post);
    }


    public function destroy(Request $request, Post $post):JsonResponse
    {
        $this->postService->deletePost($post, $request->user());
        return response()->json(['message' => 'Публикация успешно удалена ']);
    }

    public function userPosts(Request $request): JsonResponse
    {
        $posts = $this->postService->getUserPosts($request->user());
        return response()->json($posts);
    }    
}
