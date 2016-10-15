<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = "categories";

    /**
     * Get category by id
     *
     * @param $id
     * @return mixed
     */
    public static function getCategoryById($id)
    {
        $category = self::find($id);
        return $category;
    }

    /**
     * Search and get categories
     *
     * @param int $length
     * @param string $search
     * @return mixed
     */
    public static function getCategories($length = 0, $search = "")
    {
        if ($length > 0) {
            $categories = self::orderBy("id", "desc")->where("name", "like", "%" . $search . "%")->paginate($length);
        } else {
            $categories = self::orderBy("id", "desc")->get();
        }
        return $categories;
    }

    public static function getCategoriesByContentType($content_type, $length = 0, $search = "")
    {
        if ($length > 0) {
            $categories = self::orderBy("id", "desc")->where("name", "like", "%" . $search . "%")->whereContentType($content_type)->paginate($length);
        } else {
            $categories = self::orderBy("id", "desc")->whereContentType($content_type)->get();
        }
        return $categories;
    }

    /**
     * Get parent categories
     *
     * @param int $id
     * @return mixed
     */
    public static function getParentCategories($id = 0)
    {
        if ($id > 0) {
            $categories = self::whereType(1)->where("id", "!=", $id)->get();
        } else {
            $categories = self::whereType(1)->get();
        }
        return $categories;
    }

    /**
     * Get categories by publish
     *
     * @param int $publish
     * @param bool $all
     * @param bool $pages
     * @return mixed
     */
    public static function getCategoriesByPublish($publish = 1, $all = true, $pages = false)
    {
        if ($all) {
            if ($pages) {
                $categories = self::wherePublish($publish)->get();
            } else {
                $categories = self::wherePublish($publish)->whereContentType(1)->get();
            }
        } else {
            if ($pages) {
                $categories = self::wherePublish($publish)->whereType(1)->get();
            } else {
                $categories = self::wherePublish($publish)->whereType(1)->whereContentType(1)->get();
            }
        }
        return $categories;
    }

    /**
     * Get category by alias
     *
     * @param $alias
     * @return mixed
     */
    public static function getCategoryByAlias($alias)
    {
        $category = self::whereAlias($alias)->wherePublish(1)->first();
        return $category;
    }

    /**
     * Search and get category posts
     *
     * @param $category_id
     * @param int $length
     * @param string $search
     * @param int $tag
     * @return mixed
     */
    public static function getCategoryApprovedPosts($category_id, $length = 0, $search = " ", $tag = 0)
    {
        if ($length > 0) {
            if(!empty($search) || !empty($tag)) {
                if(empty($search)) {
                    $search=" ";
                }
                $posts = self::find($category_id)->posts()->whereApprove(1)->wherePublish(1)->where('title','like','%'.$search.'%')->with('tags')->orWhereHas('tags', function ($query) use ($tag) {
                    if ($tag > 0) {
                        $query->where('tag_id', $tag);
                    }
                })->paginate($length);
            }else {
                $posts = self::find($category_id)->posts()->whereApprove(1)->wherePublish(1)->paginate($length);
            }
        } else {
            $posts = self::find($category_id)->posts()->whereApprove(1)->wherePublish(1)->get();
        }
        return $posts;
    }

    /**
     * Create relationship for category subcategories
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subCategories() {
        return $this->hasMany(static::class,"parent_id")->wherePublish('1');
    }

    /**
     * Create relationship for category posts
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function posts()
    {
        return $this->belongsTo('App\Models\Post', "id", "category_id");
    }

    /**
     * Create relationship for category visits
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function visits()
    {
        return $this->belongsTo('App\Models\CategoryVisit', "id", "category_id");
    }

    /**
     * Create relationship for page content
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function content()
    {
        return $this->hasOne('App\Models\PageContent', 'page_id', 'id');
    }
}
