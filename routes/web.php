<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('login');

Route::get('/home', 'HomeController@index')->name('home');
/*
|--------------------------------------------------------------------------
| Auth
|--------------------------------------------------------------------------
*/
Route::get('login/google', 'Auth\LoginController@GoogleLogin')->name('googleLogin');
Route::get('login/google/callback', 'Auth\LoginController@handleGoogleCallback')->name('googleCallBack');
Route::group(['middleware' => ['auth']], function() {
    Route::post('logout', 'Auth\LoginController@logout')->name('logout');
});
