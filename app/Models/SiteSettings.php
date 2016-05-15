<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSettings extends Model
{
    protected $table = 'site_settings';

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
