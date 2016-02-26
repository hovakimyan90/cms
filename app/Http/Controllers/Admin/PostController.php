<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;

class PostController extends Controller
{
    public function index()
    {

    }

    public function create()
    {
        return view('admin.post.create');
    }
}
