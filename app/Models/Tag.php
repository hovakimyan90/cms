<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = 'tags';

    /**
     * Get tag by id
     *
     * @param $id
     * @return mixed
     */
    public static function getTagById($id)
    {
        $tag = Tag::find($id);
        return $tag;
    }

    public static function getTags($length = 0, $search = "")
    {
        if ($length > 0) {
            $tags = Tag::orderBy('id', 'desc')->where('name', 'like', '%' . $search . '%')->paginate($length);
        } else {
            $tags = Tag::orderBy('id', 'desc')->get()->toArray();
        }
        return $tags;
    }
}
