<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Post;

class PostPolicy
{
    /**
     * Determine if the user can update the post.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Post  $post
     * @return bool
     */
    public function update(User $user, Post $post)
    {
        // Allow if the user is the author of the post
        return $user->id === $post->user_id;
    }

    /**
     * Determine if the user can delete the post.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Post  $post
     * @return bool
     */
    public function delete(User $user, Post $post)
    {
        // Allow if the user is the author of the post
        return $user->id === $post->user_id;
    }
}
