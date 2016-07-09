<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Notification;

class NotificationController extends Controller
{
    /**
     * Get notifications
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $notifications = Notification::getNotifications();
        return view('admin.notification', compact('notifications'));
    }

    /**
     * Get unseen notifications count
     *
     * @return mixed
     */
    public function count()
    {
        $notifications = Notification::getNotificationsBySeen();
        return $notifications->count();
    }

    /**
     * Mark as read all unseen notifications
     */
    public function seen()
    {
        $notifications = Notification::getNotificationsBySeen();
        foreach ($notifications as $notification) {
            $notification->seen = 1;
            $notification->save();
        }
    }
}
