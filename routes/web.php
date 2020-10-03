<?php

use Illuminate\Support\Facades\Route;
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
Route::get('/quiz/ranking', 'QuizPVController@index')->name('quiz.ranking');
Route::group(['middleware' => ['auth']], function() {
    Route::get('quiz/search', 'QuizSearchController@index')->name('quiz.search');
    Route::get('/quiz/{quiz}', 'QuizController@show')->where('quiz', '[0-9]+')->name('quiz.show');
    Route::get('quiz/create', 'QuizController@create')->name('quiz.create');
    Route::post('quizzes', 'QuizController@store')->name('quiz.store');
});

/*
|--------------------------------------------------------------------------
| Answer
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => ['auth']], function() {
    Route::post('answers', 'AnswerController@store')->name('answer.store');
    Route::post('answers/{id}/', 'AnswerController@update')->name('answer.update');
});
/*
|--------------------------------------------------------------------------
| Category
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => ['auth']], function() {
    Route::get('/category', 'CategoryController@index')->name('category.index');
    Route::get('/category/{category}', 'CategoryController@show')->name('category.show');
    Route::post('/category/{id}/follow', 'FollowCategoryController@store')->name('category.follow');
    Route::post('/category/{id}/unfollow', 'FollowCategoryController@destroy')->name('category.follow');
});
/*
|--------------------------------------------------------------------------
| Notification
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => ['auth']], function() {
    Route::get('/notification', 'NotificationController@index')->name('notifi.index');
});
/*
|--------------------------------------------------------------------------
| User
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => ['auth']], function() {
    Route::get('/users/{user}', 'UserController@show')->name('user.show');
    Route::post('/users/{id}/follow', 'FollowUserController@store')->name('user.follow');
    Route::post('/users/{id}/unfollow', 'FollowUserController@destroy')->name('user.unfollow');
});