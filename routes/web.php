<?php

use Illuminate\Support\Facades\Route;



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
/*
|--------------------------------------------------------------------------
| Quiz
|--------------------------------------------------------------------------
*/
Route::get('/', 'QuizController@index')->name('quiz.index');
Route::get('quiz/create', 'QuizController@create')->name('quiz.create');
Route::post('quizzes', 'QuizController@store')->name('quiz.store');
Route::get('/quiz/{quiz}', 'QuizController@show')->name('quiz.show');
/*
|--------------------------------------------------------------------------
| Answer
|--------------------------------------------------------------------------
*/
Route::post('answers', 'AnswerController@store')->name('answer.store');
Route::post('answers/{id}/', 'AnswerController@update')->name('answer.update');
/*
|--------------------------------------------------------------------------
| User
|--------------------------------------------------------------------------
*/
Route::get('/users/{user}', 'UserController@show')->name('user.show');