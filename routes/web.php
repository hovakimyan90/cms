<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

use Illuminate\Support\Facades\Route;

Route::get('/' . config('app.admin_route_name'), 'Admin\AuthController@login');
Route::post('/' . config('app.admin_route_name'), 'Admin\AuthController@login');
Route::get('/' . config('app.admin_route_name') . '/logout', 'Admin\AuthController@logout');
Route::group(['middleware' => 'visit'], function () {
    Route::get('/', 'Site\HomeController@index')->name('home');
    Route::get('/register', 'Site\AuthController@register');
    Route::post('/register', 'Site\AuthController@register');
    Route::get('/user/activation/{token}', 'Site\AuthController@activation');
    Route::get('/forget/password', 'Site\AuthController@forget');
    Route::post('/forget/password', 'Site\AuthController@forget');
    Route::get('/reset/password/{token}', 'Site\AuthController@reset');
    Route::post('/reset/password/{token}', 'Site\AuthController@reset');
    Route::get('/login', 'Site\AuthController@login');
    Route::post('/login', 'Site\AuthController@login');
    Route::get('/logout', 'Site\AuthController@logout');
    Route::get('/category/{alias}', 'Site\SiteController@category');
    Route::post('/category/{alias}', 'Site\SiteController@category');
    Route::get('/news/{alias}', 'Site\SiteController@post');
    Route::group(['middleware' => 'site_auth'], function () {
        Route::get('/edit', 'Site\UserController@edit');
        Route::post('/edit', 'Site\UserController@edit');
        Route::get('/posts', 'Site\PostController@index')->name('posts');
        Route::post('/posts', 'Site\PostController@index')->name('posts');
        Route::get('/post/create', 'Site\PostController@create');
        Route::post('/post/create', 'Site\PostController@create');
        Route::get('/post/edit/{id}', 'Site\PostController@edit');
        Route::post('/post/edit/{id}', 'Site\PostController@edit');
        Route::get('/post/delete/{id}', 'Site\PostController@delete');
        Route::post('/post/delete', 'Site\PostController@delete');
        Route::get('/post/export', 'Site\PostController@export');
        Route::get('/notifications', 'Site\NotificationController@index');
        Route::get('/notifications/count', 'Site\NotificationController@count');
        Route::get('/notifications/seen', 'Site\NotificationController@seen');
    });
});
Route::group(['middleware' => 'admin_auth'], function () {
    Route::get('/' . config('app.admin_route_name') . '/dashboard', 'Admin\DashboardController@index');
    Route::get('/' . config('app.admin_route_name') . '/categories', 'Admin\CategoryController@index')->name('categories');
    Route::get('/' . config('app.admin_route_name') . '/category/create', 'Admin\CategoryController@create');
    Route::post('/' . config('app.admin_route_name') . '/category/create', 'Admin\CategoryController@create');
    Route::get('/' . config('app.admin_route_name') . '/category/edit/{id}', 'Admin\CategoryController@edit');
    Route::post('/' . config('app.admin_route_name') . '/category/edit/{id}', 'Admin\CategoryController@edit');
    Route::get('/' . config('app.admin_route_name') . '/category/delete/{id}', 'Admin\CategoryController@delete');
    Route::post('/' . config('app.admin_route_name') . '/category/delete', 'Admin\CategoryController@delete');
    Route::get('/' . config('app.admin_route_name') . '/category/export', 'Admin\CategoryController@export');
    Route::get('/' . config('app.admin_route_name') . '/tags', 'Admin\TagController@index')->name('tags');
    Route::get('/' . config('app.admin_route_name') . '/tag/create', 'Admin\TagController@create');
    Route::post('/' . config('app.admin_route_name') . '/tag/create', 'Admin\TagController@create');
    Route::get('/' . config('app.admin_route_name') . '/tag/edit/{id}', 'Admin\TagController@edit');
    Route::post('/' . config('app.admin_route_name') . '/tag/edit/{id}', 'Admin\TagController@edit');
    Route::get('/' . config('app.admin_route_name') . '/tag/delete/{id}', 'Admin\TagController@delete');
    Route::post('/' . config('app.admin_route_name') . '/tag/delete', 'Admin\TagController@delete');
    Route::get('/' . config('app.admin_route_name') . '/tag/export', 'Admin\TagController@export');
    Route::get('/' . config('app.admin_route_name') . '/posts', 'Admin\PostController@index')->name('admin_posts');
    Route::get('/' . config('app.admin_route_name') . '/post/create', 'Admin\PostController@create');
    Route::post('/' . config('app.admin_route_name') . '/post/create', 'Admin\PostController@create');
    Route::get('/' . config('app.admin_route_name') . '/post/edit/{id}', 'Admin\PostController@edit');
    Route::post('/' . config('app.admin_route_name') . '/post/edit/{id}', 'Admin\PostController@edit');
    Route::get('/' . config('app.admin_route_name') . '/post/delete/{id}', 'Admin\PostController@delete');
    Route::post('/' . config('app.admin_route_name') . '/post/delete', 'Admin\PostController@delete');
    Route::get('/' . config('app.admin_route_name') . '/post/approve/{id}', 'Admin\PostController@approve');
    Route::get('/' . config('app.admin_route_name') . '/post/disapprove/{id}', 'Admin\PostController@disapprove');
    Route::get('/' . config('app.admin_route_name') . '/post/export', 'Admin\PostController@export');
    Route::get('/' . config('app.admin_route_name') . '/users', 'Admin\UserController@index')->name('users');
    Route::get('/' . config('app.admin_route_name') . '/user/create', 'Admin\UserController@create');
    Route::post('/' . config('app.admin_route_name') . '/user/create', 'Admin\UserController@create');
    Route::get('/' . config('app.admin_route_name') . '/user/edit/{id}', 'Admin\UserController@edit');
    Route::post('/' . config('app.admin_route_name') . '/user/edit/{id}', 'Admin\UserController@edit');
    Route::get('/' . config('app.admin_route_name') . '/user/delete/{id}', 'Admin\UserController@delete');
    Route::post('/' . config('app.admin_route_name') . '/user/delete', 'Admin\UserController@delete');
    Route::get('/' . config('app.admin_route_name') . '/user/export', 'Admin\UserController@export');
    Route::get('/' . config('app.admin_route_name') . '/settings', 'Admin\SettingsController@index');
    Route::post('/' . config('app.admin_route_name') . '/settings', 'Admin\SettingsController@index');
    Route::get('/' . config('app.admin_route_name') . '/notifications', 'Admin\NotificationController@index');
    Route::get('/' . config('app.admin_route_name') . '/notifications/count', 'Admin\NotificationController@count');
    Route::get('/' . config('app.admin_route_name') . '/notifications/seen', 'Admin\NotificationController@seen');
    Route::get('/' . config('app.admin_route_name') . '/pages', 'Admin\PageController@index')->name('pages');
    Route::get('/' . config('app.admin_route_name') . '/page/create', 'Admin\PageController@create');
    Route::post('/' . config('app.admin_route_name') . '/page/create', 'Admin\PageController@create');
    Route::get('/' . config('app.admin_route_name') . '/page/edit/{id}', 'Admin\PageController@edit');
    Route::post('/' . config('app.admin_route_name') . '/page/edit/{id}', 'Admin\PageController@edit');
    Route::get('/' . config('app.admin_route_name') . '/page/delete/{id}', 'Admin\PageController@delete');
    Route::post('/' . config('app.admin_route_name') . '/page/delete', 'Admin\PageController@delete');
    Route::get('/' . config('app.admin_route_name') . '/page/export', 'Admin\PageController@export');
});