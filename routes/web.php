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
/*
Route::get('/', function () {
    return view('welcome');
});
*/

Route::group(['middleware' => ['authMiddleware']], function(){
    Route::get('users/create', array('uses' => 'UserController@create'))->name('user.create');
    Route::post('users/create', array('uses' => 'UserController@store'))->name('user.store');
    Route::get('users/edit', array('uses' => 'UserController@edit'))->name('user.edit');
    Route::post('users/edit', array('uses' => 'UserController@update'))->name('user.update');
    Route::get('users/destroy', array('uses' => 'UserController@destroy'))->name('user.destroy');
    
    Route::get('posts/create', array('uses' => 'PostController@create'))->name('post.create');
    Route::post('posts/create', array('uses' => 'PostController@store'))->name('post.store');
    Route::get('posts/edit', array('uses' => 'PostController@edit'))->name('post.edit');
    Route::post('posts/edit', array('uses' => 'PostController@update'))->name('post.update');
    Route::get('posts/destroy', array('uses' => 'PostController@destroy'))->name('post.destroy');
    Route::get('all/posts/create', array('uses' => 'PostController@create_admin_dashbord'))->name('post.create_admin_dashbord');
});

Route::group([], function(){
    Route::get('home', array('uses' => 'HomeController@index'))->name('home');
    Route::get('login', array('uses' => 'LoginController@create'))->name('login.create');
    Route::post('login', array('uses' => 'LoginController@doLogin'))->name('login.do');
    Route::get('logout', array('uses' => 'LoginController@doLogout'))->name('login.doLogout');
    
    Route::match(['get', 'post'], 'check-valid-user', array('uses' => 'UserController@checkValidUser'))->name('user.checkValidUser');
});

Route::get('/', function () {
    return redirect()->route('home');
});
