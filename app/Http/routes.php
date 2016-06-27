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
Route::get('/admin/logout', 'Admin\AuthController@logout');
Route::get('/', ['as' => 'home', 'uses' => 'Site\HomeController@index']);
Route::get('/register', 'Site\AuthController@register');
Route::post('/register', 'Site\AuthController@register');
Route::get('/user/activation/{token}', 'Site\AuthController@activation');
Route::get('/forget/password', 'Site\AuthController@forget');
Route::post('/forget/password', 'Site\AuthController@forget');
Route::get('/reset/password/{token}', 'Site\AuthController@reset');
Route::post('/reset/password/{token}', 'Site\AuthController@reset');
Route::group(['middleware' => 'auth'], function () {
    Route::get('/admin/dashboard', 'Admin\DashboardController@index');
    Route::get('/admin/categories', ['as' => 'categories', 'uses' => 'Admin\CategoryController@index']);
    Route::post('/admin/categories', ['as' => 'categories', 'uses' => 'Admin\CategoryController@index']);
    Route::get('/admin/category/create', 'Admin\CategoryController@create');
    Route::post('/admin/category/create', 'Admin\CategoryController@create');
    Route::get('/admin/category/edit/{id}', 'Admin\CategoryController@edit');
    Route::post('/admin/category/edit/{id}', 'Admin\CategoryController@edit');
    Route::get('/admin/category/delete/{id}', 'Admin\CategoryController@delete');
    Route::post('/admin/category/delete', 'Admin\CategoryController@delete');
    Route::get('/admin/category/export', 'Admin\CategoryController@export');
    Route::get('/admin/tags', ['as' => 'tags', 'uses' => 'Admin\TagController@index']);
    Route::post('/admin/tags', ['as' => 'tags', 'uses' => 'Admin\TagController@index']);
    Route::get('/admin/tag/create', 'Admin\TagController@create');
    Route::post('/admin/tag/create', 'Admin\TagController@create');
    Route::get('/admin/tag/edit/{id}', 'Admin\TagController@edit');
    Route::post('/admin/tag/edit/{id}', 'Admin\TagController@edit');
    Route::get('/admin/tag/delete/{id}', 'Admin\TagController@delete');
    Route::post('/admin/tag/delete', 'Admin\TagController@delete');
    Route::get('/admin/tag/export', 'Admin\TagController@export');
    Route::get('/admin/posts', ['as' => 'posts', 'uses' => 'Admin\PostController@index']);
    Route::post('/admin/posts', ['as' => 'posts', 'uses' => 'Admin\PostController@index']);
    Route::get('/admin/post/create', 'Admin\PostController@create');
    Route::post('/admin/post/create', 'Admin\PostController@create');
    Route::get('/admin/post/edit/{id}', 'Admin\PostController@edit');
    Route::post('/admin/post/edit/{id}', 'Admin\PostController@edit');
    Route::get('/admin/post/delete/{id}', 'Admin\PostController@delete');
    Route::post('/admin/post/delete', 'Admin\PostController@delete');
    Route::get('/admin/post/export', 'Admin\PostController@export');
    Route::get('/admin/users', ['as' => 'users', 'uses' => 'Admin\UserController@index']);
    Route::post('/admin/users', ['as' => 'users', 'uses' => 'Admin\UserController@index']);
    Route::get('/admin/user/create', 'Admin\UserController@create');
    Route::post('/admin/user/create', 'Admin\UserController@create');
    Route::get('/admin/user/edit/{id}', 'Admin\UserController@edit');
    Route::post('/admin/user/edit/{id}', 'Admin\UserController@edit');
    Route::get('/admin/user/delete/{id}', 'Admin\UserController@delete');
    Route::post('/admin/user/delete', 'Admin\UserController@delete');
    Route::get('/admin/user/export', 'Admin\UserController@export');
    Route::get('/admin/settings', 'Admin\SettingsController@index');
    Route::post('/admin/settings', 'Admin\SettingsController@index');
});