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
        $thumbnails = $this->attributes['thumbnails']['name'][0] ? $this->attributes['thumbnails'] : null;
        unset($this->attributes['thumbnails']);
        $id = app()->db->insert('posts', $this->attributes);
        if ($thumbnail && $fileUrl = upload_file($thumbnail)) {
            $fileUrl = substr($fileUrl, mb_strlen(URL_ROOT));
            app()->db->update('posts', ['id' => $id, 'thumbnail' => $fileUrl]);
        }
        if ($thumbnails) {
            for ($i = 0, $iMax = count($thumbnails['name']); $i < $iMax; $i++) {
                if ($fileUrl = upload_file($thumbnails, $i)) {
                    $fileUrl = substr($fileUrl, mb_strlen(URL_ROOT));
                    app()->db->insert('gallery', ['post_id' => $id, 'image' => $fileUrl]);
                }
            }

        }

        return $id;
    }
}