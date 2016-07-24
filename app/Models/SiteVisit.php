<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
        $visits = self::select(DB::raw('Date(created_at) as date'), DB::raw('COUNT(*) as "views"'))
            ->groupBy('date')
            ->orderBy('date', 'DESC')
            ->get();
        return $visits;
    }
}
