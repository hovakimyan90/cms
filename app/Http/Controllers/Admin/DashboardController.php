<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Post;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $registered_user_count = User::getUsers()->count();
        $approved_posts_count = Post::getPosts()->count();
        $disapproved_posts_count = Post::getPosts(0)->count();
        return view('admin.dashboard', compact('registered_user_count', 'approved_posts_count', 'disapproved_posts_count'));
    }
}
