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
    public static function getPosts($length = 0, $search = "", $author_id = 0)
    {
        if ($length > 0) {
            if ($author_id > 0) {
                $posts = Post::orderBy("id", "desc")->where("title", "like", "%" . $search . "%")->whereAuthor_id($author_id)->paginate($length);
            } else {
                $posts = Post::orderBy("id", "desc")->where("title", "like", "%" . $search . "%")->paginate($length);
            }
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

    public function category()
    {
        return $this->hasOne('App\Models\Category', 'id', 'category_id');
    }

    /**
     * Create relationship for post author
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function author()
    {
        return $this->hasOne('App\Models\User', 'id', 'author_id');
    }
}
