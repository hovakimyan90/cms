<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = "tags";

    /**
     * Get tag by id
     *
     * @param $id
     * @return mixed
     */
    public static function getTagById($id)
    {
        $tag = self::find($id);
        return $tag;
    }

    /**
     * Search and get tags
     *
     * @param int $length
     * @param string $search
     * @return mixed
     */
    public static function getTags($length = 0, $search = "")
    {
        if ($length > 0) {
            $tags = self::orderBy("id", "desc")->where("name", "like", "%" . $search . "%")->paginate($length);
        } else {
            $tags = self::orderBy("id", "desc")->get();
        }
        return $tags;
    }
}
