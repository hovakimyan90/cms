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

    /**
     * Get parent categories
     *
     * @param int $id
     * @return mixed
     */
    public static function getParentCategories($id = 0)
    {
        if ($id > 0) {
            $categories = self::whereType("parent")->where("id", "!=", $id)->get();
        } else {
            $categories = self::whereType("parent")->get();
        }
        return $categories;
    }

    /**
     * Get categories by publish and sub
     *
     * @param int $publish
     * @param bool $sub
     * @return mixed
     */
    public static function getCategoriesByPublish($publish = 1, $sub = true)
    {
        if ($sub) {
            $categories = self::wherePublish($publish)->get();
        } else {
            $categories = self::wherePublish($publish)->whereType('parent')->get();
        }
        return $categories;
    }

    /**
     * Get subcategories by parent id
     *
     * @param $parent_id
     * @return mixed
     */
    public static function getSubcategoriesByParentId($parent_id)
    {
        $categories = self::whereParent_id($parent_id)->wherePublish(1)->get();
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
     * Get category approved posts by category id
     *
     * @param $category_id
     * @param int $length
     * @return mixed
     */
    public static function getCategoryApprovedPosts($category_id, $length = 0, $search = "")
    {
        if ($length > 0) {
            $posts = self::find($category_id)->posts()->whereApprove(1)->wherePublish(1)->where("title", "like", "%" . $search . "%")->paginate($length);
        } else {
            $posts = self::find($category_id)->posts()->whereApprove(1)->wherePublish(1)->get();
        }
        return $posts;
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
}
