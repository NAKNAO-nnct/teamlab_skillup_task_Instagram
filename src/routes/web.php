<?php

use Illuminate\Support\Facades\Route;

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
Route::auth();

// auth関連
// Route::get('/login', 'Auth\LoginController@showLoginForm');
// Route::post('/login', 'Auth\LoginController@login');
// Route::post('/logout', 'Auth\LoginController@logout');

Route::get('/user', 'UserController@index');
Route::get('github', 'Github\GithubController@top');

// login
Route::get('login/github', 'Auth\LoginController@redirectToProvider');
Route::get('login/github/callback', 'Auth\LoginController@handleProviderCallback');


Route::get('/', 'BbsController@index');

Route::group(['middleware' => 'auth'], function() {
    Route::get('/upload', function(){
        return view('upload');
    });
    // 投稿処理
    Route::post('/upload', 'BbsController@upload');
});

// 記事
Route::group(['prefix' => 'article'], function() {
});
// ログイン必須
Route::group(['prefix' => 'article', 'middleware' => 'auth'], function() {
    Route::get('{id}', 'BbsController@viewId');
    
    Route::get('{id}/good', 'BbsController@good');
    Route::get('{id}/good/list', 'BbsController@goodUserList');

    Route::get('{id}/delete', 'BbsController@delete');
});

// ユーザ
Route::get('user/{id}', 'UserController@userPageId');