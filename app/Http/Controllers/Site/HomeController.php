<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Http\Requests;

class HomeController extends Controller
{
    public function index()
    {
        $title = 'Home';
        return view('site.home')->with(compact('title'));
    }
}
