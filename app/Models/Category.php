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
        $category = Category::find($id);
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
            $categories = Category::orderBy("id", "desc")->where("name", "like", "%" . $search . "%")->paginate($length);
        } else {
            $categories = Category::orderBy("id", "desc")->get();
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
            $categories = Category::whereType("parent_id")->where("id", "!=", $id)->get();
        } else {
            $categories = Category::whereType("parent_id")->get();
        }
        return $categories;
    }

    /**
     * Get categories by publish
     *
     * @param int $publish
     * @return mixed
     */
    public static function getCategoriesByPublish($publish = 1)
    {
        $categories = self::where('publish', $publish)->get();
        return $categories;
    }

    /**
     * Create relationship for category posts
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function posts() {
        return $this->belongsTo('App\Models\Post', "id","category_id");
    }
}
