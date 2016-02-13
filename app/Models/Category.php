<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    /**
     * Get all categories
     *
     * @param int $length
     * @param string $search
     * @return mixed
     */
    public static function getCategories($length = 0, $search = "")
    {
        if ($length > 0) {
            $categories = Category::orderBy('id', 'desc')->where('name', 'like', '%' . $search . '%')->paginate($length);
        } else {
            $categories = Category::orderBy('id', 'desc')->get()->toArray();
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
            $categories = Category::whereType('parent')->where('id', '!=', $id)->get()->toArray();
        } else {
            $categories = Category::whereType('parent')->get()->toArray();
        }
        return $categories;
    }

    /**
     * Get category by id
     *
     * @param $id
     * @return mixed
     */
    public static function getCategory($id)
    {
        $category = Category::find($id);
        return $category;
    }
}
