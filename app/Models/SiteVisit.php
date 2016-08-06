<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteVisit extends Model
{
    protected $table = 'site_visits';

    /**
     * Get site visits
     *
     * @return mixed
     */
    public static function getVisits()
    {
        $visits = self::selectRaw('Date(created_at) as date,COUNT(*) as "views"')
            ->groupBy('date')
            ->orderBy('date', 'DESC')
            ->get();
        return $visits;
    }
}
