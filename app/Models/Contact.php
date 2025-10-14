<?php

namespace app\Models;

use core\Model;

class Contact extends Model
{
    public array $fillable = ['name', 'user_name', 'email', 'content',];
    public array $attributes = [];
    public array $rules = [
        'name' => ['required' => true],
        'email' => ['email' => true, 'min' => 5, 'max' => 30],
        'content' => ['min' => 20],
    ];
    public array $labels = [
        'name' => 'Name',
        'email' => 'Email',
        'content' => 'Content',
    ];

}