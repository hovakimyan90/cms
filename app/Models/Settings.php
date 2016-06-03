<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    protected $table = 'settings';

    /**
     * Get site settings
     *
     * @return mixed
     */
    public static function getSettings()
    {
        $settings = self::find(1);
        return $settings;
    }
}
