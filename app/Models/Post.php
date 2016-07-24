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
        $post = self::find($id);
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
    public static function getPosts($length = 0, $search = "", $author_id = 0)
    {
        if ($length > 0) {
            if ($author_id > 0) {
                $posts = self::orderBy("id", "desc")->where("title", "like", "%" . $search . "%")->whereAuthor_id($author_id)->paginate($length);
            } else {
                $posts = self::orderBy("id", "desc")->where("title", "like", "%" . $search . "%")->paginate($length);
            }
        } else {
            if ($author_id > 0) {
                $posts = self::orderBy("id", "desc")->whereAuthor_id($author_id)->get();
            } else {
                $posts = self::orderBy("id", "desc")->get();
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
        $posts = self::orderBy("id", "desc")->whereApprove($approve)->get();
        return $posts;
    }

    /**
     * Get post by alias
     *
     * @param $alias
     * @return mixed
     */
    public static function getPostByAlias($alias)
    {
        $post = self::whereAlias($alias)->wherePublish(1)->first();
        return $post;
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

    /**
     * Create relationship for post visits
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function visits()
    {
        return $this->belongsTo('App\Models\PostVisit', 'id', 'post_id');
    }
}
