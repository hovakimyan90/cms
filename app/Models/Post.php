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
     * @param int $author_id
     * @return mixed
     */
    public static function getPosts($author_id = 0, $length = 0, $search = "")
    {
        if ($length > 0) {
            if ($author_id > 0) {
                $posts = Post::orderBy("id", "desc")->where("title", "like", "%" . $search . "%")->whereAuthor_id($author_id)->paginate($length);
            } else {
                $posts = Post::orderBy("id", "desc")->where("title", "like", "%" . $search . "%")->paginate($length);
            }
        } else {
            if ($author_id > 0) {
                $posts = Post::orderBy("id", "desc")->whereAuthor_id($author_id)->get();
            } else {
                $posts = Post::orderBy("id", "desc")->get();
            }
        }
        return $posts;
    }

    /**
     * Get post by status
     *
     * @param int $approve
     * @return mixed
     */
    public static function getPostsByStatus($approve = 1)
    {
        $posts = Post::orderBy("id", "desc")->whereApprove($approve)->get();
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

    /**
     * Create relationship for post category
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
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
