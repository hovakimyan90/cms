<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use Illuminate\Support\Facades\Route;

Route::get('/admin', 'Admin\AuthController@login');
Route::post('/admin', 'Admin\AuthController@login');
Route::get('/' . config('app.admin_route_name') . '/logout', 'Admin\AuthController@logout');
Route::get('/', ['as' => 'home', 'uses' => 'Site\HomeController@index']);
Route::get('/register', 'Site\AuthController@register');
Route::post('/register', 'Site\AuthController@register');
Route::get('/user/activation/{token}', 'Site\AuthController@activation');
Route::get('/forget/password', 'Site\AuthController@forget');
Route::post('/forget/password', 'Site\AuthController@forget');
Route::get('/reset/password/{token}', 'Site\AuthController@reset');
Route::post('/reset/password/{token}', 'Site\AuthController@reset');
Route::group(['middleware' => 'auth'], function () {
    Route::get('/' . config('app.admin_route_name') . '/dashboard', 'Admin\DashboardController@index');
    Route::get('/' . config('app.admin_route_name') . '/categories', ['as' => 'categories', 'uses' => 'Admin\CategoryController@index']);
    Route::post('/' . config('app.admin_route_name') . '/categories', ['as' => 'categories', 'uses' => 'Admin\CategoryController@index']);
    Route::get('/' . config('app.admin_route_name') . '/category/create', 'Admin\CategoryController@create');
    Route::post('/' . config('app.admin_route_name') . '/category/create', 'Admin\CategoryController@create');
    Route::get('/' . config('app.admin_route_name') . '/category/edit/{id}', 'Admin\CategoryController@edit');
    Route::post('/' . config('app.admin_route_name') . '/category/edit/{id}', 'Admin\CategoryController@edit');
    Route::get('/' . config('app.admin_route_name') . '/category/delete/{id}', 'Admin\CategoryController@delete');
    Route::post('/' . config('app.admin_route_name') . '/category/delete', 'Admin\CategoryController@delete');
    Route::get('/' . config('app.admin_route_name') . '/category/export', 'Admin\CategoryController@export');
    Route::get('/' . config('app.admin_route_name') . '/tags', ['as' => 'tags', 'uses' => 'Admin\TagController@index']);
    Route::post('/' . config('app.admin_route_name') . '/tags', ['as' => 'tags', 'uses' => 'Admin\TagController@index']);
    Route::get('/' . config('app.admin_route_name') . '/tag/create', 'Admin\TagController@create');
    Route::post('/' . config('app.admin_route_name') . '/tag/create', 'Admin\TagController@create');
    Route::get('/' . config('app.admin_route_name') . '/tag/edit/{id}', 'Admin\TagController@edit');
    Route::post('/' . config('app.admin_route_name') . '/tag/edit/{id}', 'Admin\TagController@edit');
    Route::get('/' . config('app.admin_route_name') . '/tag/delete/{id}', 'Admin\TagController@delete');
    Route::post('/' . config('app.admin_route_name') . '/tag/delete', 'Admin\TagController@delete');
    Route::get('/' . config('app.admin_route_name') . '/tag/export', 'Admin\TagController@export');
    Route::get('/' . config('app.admin_route_name') . '/posts', ['as' => 'posts', 'uses' => 'Admin\PostController@index']);
    Route::post('/' . config('app.admin_route_name') . '/posts', ['as' => 'posts', 'uses' => 'Admin\PostController@index']);
    Route::get('/' . config('app.admin_route_name') . '/post/create', 'Admin\PostController@create');
    Route::post('/' . config('app.admin_route_name') . '/post/create', 'Admin\PostController@create');
    Route::get('/' . config('app.admin_route_name') . '/post/edit/{id}', 'Admin\PostController@edit');
    Route::post('/' . config('app.admin_route_name') . '/post/edit/{id}', 'Admin\PostController@edit');
    Route::get('/' . config('app.admin_route_name') . '/post/delete/{id}', 'Admin\PostController@delete');
    Route::post('/' . config('app.admin_route_name') . '/post/delete', 'Admin\PostController@delete');
    Route::get('/' . config('app.admin_route_name') . '/post/export', 'Admin\PostController@export');
    Route::get('/' . config('app.admin_route_name') . '/users', ['as' => 'users', 'uses' => 'Admin\UserController@index']);
    Route::post('/' . config('app.admin_route_name') . '/users', ['as' => 'users', 'uses' => 'Admin\UserController@index']);
    Route::get('/' . config('app.admin_route_name') . '/user/create', 'Admin\UserController@create');
    Route::post('/' . config('app.admin_route_name') . '/user/create', 'Admin\UserController@create');
    Route::get('/' . config('app.admin_route_name') . '/user/edit/{id}', 'Admin\UserController@edit');
    Route::post('/' . config('app.admin_route_name') . '/user/edit/{id}', 'Admin\UserController@edit');
    Route::get('/' . config('app.admin_route_name') . '/user/delete/{id}', 'Admin\UserController@delete');
    Route::post('/' . config('app.admin_route_name') . '/user/delete', 'Admin\UserController@delete');
    Route::get('/' . config('app.admin_route_name') . '/user/export', 'Admin\UserController@export');
    Route::get('/' . config('app.admin_route_name') . '/settings', 'Admin\SettingsController@index');
    Route::post('/' . config('app.admin_route_name') . '/settings', 'Admin\SettingsController@index');
});