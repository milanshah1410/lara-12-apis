<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Services\PostService;
use Illuminate\Http\JsonResponse;

class PostController extends Controller
{
    public function __construct(private PostService $postService) {}

    public function index()
    {
        $perPage = request()->input('per_page', 10); // Default is 10 if not provided
        $posts = Post::latest()->paginate($perPage);
        return PostResource::collection($posts);
    }

    public function store(StorePostRequest $request): JsonResponse
    {
        $post = $this->postService->create($request->validated());
        return response()->json(new PostResource($post), 201);
    }

    public function show(Post $post)
    {
        return new PostResource($post);
    }

    public function update(UpdatePostRequest $request, Post $post): JsonResponse
    {
        $post = $this->postService->update($post, $request->validated());
        return response()->json(new PostResource($post), 200);
    }

    public function destroy(Post $post): JsonResponse
    {
        $this->postService->delete($post);
        return response()->json(['message' => 'Post deleted successfully'], 204);
    }
}
