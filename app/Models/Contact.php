<?php

namespace app\Models;

use core\Model;

class Contact extends Model
{
    public array $fillable = ['email', 'text', 'name'];
    public array $attributes = [];

}