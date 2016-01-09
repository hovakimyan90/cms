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
});