<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::resource('category', 'CategoryController');
Route::resource('paper', 'PaperController');
Route::resource('archive', 'ArchiveController');

Route::group(['prefix' => 'user'], function () {
    Route::get('password', 'UserController@password');
    Route::post('login', 'UserController@login');
});
