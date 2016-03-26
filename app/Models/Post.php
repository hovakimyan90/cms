<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = "posts";

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

    /**
     * Search and get posts
     *
     * @param int $length
     * @param string $search
     * @return mixed
     */
    public static function getPosts($length = 0, $search = "")
    {
        if ($length > 0) {
            $posts = Post::orderBy("id", "desc")->where("title", "like", "%" . $search . "%")->paginate($length);
        } else {
            $posts = Post::orderBy("id", "desc")->get();
        }
        return $posts;
    }

    /**
     * Create relationship for post tags
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany('App\Models\Tag', "post_tags", "post_id", "tag_id");
    }
}
