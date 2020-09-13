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
Route::group(['middleware' => ['auth']], function() {
    Route::get('quiz/create', 'QuizController@create')->name('quiz.create');
    Route::post('quizzes', 'QuizController@store')->name('quiz.store');
});
Route::get('/', 'QuizController@index')->name('quiz.index');
Route::get('/quiz/{quiz}', 'QuizController@show')->name('quiz.show');
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
    Route::post('/category', 'FollowCategoryController@store')->name('follow.category');
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
Route::get('/users/{user}', 'UserController@show')->name('user.show');