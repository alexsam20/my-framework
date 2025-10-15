<?php

namespace app\Models;

use core\Model;

class Post extends Model
{
    protected string $table = 'posts';

    public array $fillable = ['title', 'content'];

    public array $rules = [
        'title' => ['required' => true],
        'content' => ['min' => 10],
    ];

    public array $labels = [
        'title' => 'Post title',
        'content' => 'Post Content',
    ];
}