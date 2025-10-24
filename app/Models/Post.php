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
        'thumbnail' => [/*'file' => true,*/ 'extension' => 'jpg|jpeg|png', 'size' => 1_048_576],
        'thumbnails' => ['extension' => 'jpg|jpeg|png', 'size' => 1_048_576],
    ];

    public array $labels = [
        'title' => 'Post title',
        'content' => 'Post Content',
        'slug' => 'Slug',
        'thumbnail' => 'Thumbnail',
        'thumbnails' => 'Thumbnails',
    ];

    public function savePost(): false|string
    {
        $thumbnail = $this->attributes['thumbnail']['name'] ? $this->attributes['thumbnail'] : null;
        unset($this->attributes['thumbnail']);
        $id = app()->db->insert('posts', $this->attributes);
        if ($thumbnail) {
            if ($fileUrl = upload_file($thumbnail)) {
                $fileUrl = substr($fileUrl, mb_strlen(URL_ROOT));
                app()->db->update('posts', ['id' => $id, 'thumbnail' => $fileUrl]);
            }
        }

        return $id;
    }
}