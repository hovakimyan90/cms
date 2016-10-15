<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\SiteVisit;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Dashboard
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $registered_user_count = User::getUsers()->count();
        $approved_users_count = User::getApprovedUsers()->count();
        $disapproved_users_count = User::getDisapprovedUsers()->count();
        $approved_posts_count = Post::getPostsByStatus()->count();
        $disapproved_posts_count = Post::getPostsByStatus(0)->count();
        $site_visits = SiteVisit::getVisits();
        $visits = [];
        foreach ($site_visits as $visit) {
            $visit = array('date' => $visit['date'], 'visit' => $visit['views']);
            $visits[] = $visit;
        }
        return view('admin.dashboard', compact('registered_user_count', 'approved_users_count', 'disapproved_users_count','approved_posts_count', 'disapproved_posts_count', 'visits'));
    }
}
