<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title',
        'body',
        'status',
    ];

    protected static function booted()
    {
        static::creating(function ($post) {
            // Automatically set the user_id from the currently authenticated user
            $post->user_id = auth()->id();
        });
    }

    // Define relationships (if any)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
