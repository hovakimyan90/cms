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
});