<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Notification extends Model
{
    protected $table = 'notifications';

    /**
     * Get notifications
     *
     * @return mixed
     */
    public static function getNotifications()
    {
        $notifications = self::whereTo(Auth::user()->id)->get();
        return $notifications;
    }

    /**
     * Get notification by seen
     *
     * @param int $seen
     * @return mixed
     */
    public static function getNotificationsBySeen($seen = 0)
    {
        $notifications = self::whereTo(Auth::user()->id)->whereSeen($seen)->get();
        return $notifications;
    }

    /**
     * Get notifications by sender id
     *
     * @param $user_id
     * @return mixed
     */
    public static function getNotificationBySenderId($user_id)
    {
        $notifications = self::whereFrom($user_id)->get();
        return $notifications;
    }

    /**
     * Get notifications by reader id
     *
     * @param $user_id
     * @return mixed
     */
    public static function getNotificationByReaderId($user_id)
    {
        $notifications = self::whereTo($user_id)->get();
        return $notifications;
    }

    /**
     * Create relationship for sender
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function sender()
    {
        return $this->hasOne('App\Models\User', 'id', 'from');
    }

    /**
     * Create relationship for reader
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function reader()
    {
        return $this->hasOne('App\Models\User', 'id', 'to');
    }
}
