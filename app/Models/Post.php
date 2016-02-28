<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';

    /**
     * Get post by id
     *
     * @param $id
     * @return mixed
     */
    public static function getPostById($id)
    {
        $post = Post::find($id);
        return $post;
    }
}
