<?php

namespace app\Models;

use core\Model;

class Post extends Model
{
    protected string $table = 'posts';

    public array $fillable = ['title', 'content', 'slug'];

    public array $rules = [
        'title' => ['required' => true],
        'content' => ['min' => 10],
        'slug' => ['required' => true, 'unique' => 'posts:slug'],
    ];

    public array $labels = [
        'title' => 'Post title',
        'content' => 'Post Content',
        'slug' => 'Slug',
    ];
}