<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlbumImage extends Model
{
    protected $table = 'album_images';

    /**
     * Get image by id
     *
     * @param $id
     * @return mixed
     */
    public static function getImageById($id)
    {
        $image = self::find($id);
        return $image;
    }

    /**
     * Search and get images
     *
     * @param int $length
     * @param string $search
     * @return mixed
     */
    public static function getImages($length = 0, $search = "")
    {
        if ($length > 0) {
            $images = self::orderBy("id", "desc")->where("title", "like", "%" . $search . "%")->paginate($length);
        } else {
            $images = self::orderBy("id", "desc")->get();
        }
        return $images;
    }

    public function album()
    {
        return $this->hasOne('App\Models\Category', 'id', 'album_id');
    }
}
