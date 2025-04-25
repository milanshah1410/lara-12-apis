<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Services\PostService;
use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; // <-- Import the trait

class PostController extends Controller
{
    use AuthorizesRequests;

    public function __construct(private PostService $postService) {}

    /**
     * List Posts.
     *
     * Retrieves a paginated list of all posts.
     * Supports dynamic pagination and optional filters.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $perPage = request()->input('per_page', 10); // Default is 10 if not provided
        $posts = Post::with('user')->latest()->paginate($perPage);
        return PostResource::collection($posts);
    }

    /**
     * Create Post.
     *
     * Handles the creation of a new post with the provided data.
     * Validates input and stores the post in the database.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StorePostRequest $request): JsonResponse
    {
        $post = $this->postService->create($request->validated());
        return response()->json(new PostResource($post), 201);
    }

    /**
     * Show Post.
     *
     * Retrieves a single post by its unique identifier.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $post = Post::with('user')->find($id);

        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }

        return new PostResource($post);
    }

    /**
     * Update Post.
     *
     * Updates the details of an existing post.
     * Requires valid input and a valid post ID.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdatePostRequest $request, $id): JsonResponse
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }

        $this->authorize('update', $post); // Check if the user can update this post

        $post = $this->postService->update($post, $request->validated());
        return response()->json(new PostResource($post), 200);
    }

    /**
     * Delete Post.
     *
     * Deletes a post by its ID.
     * Returns a success message upon successful deletion.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }

        $this->authorize('delete', $post);

        $this->postService->delete($post);
        return response()->json(['message' => 'Post deleted successfully'], 204);
    }
}
