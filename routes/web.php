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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();
/*
 * Admin routes
 * */
Route::group([
    'as' => 'admin.',
    'prefix' => 'admin',
    'middleware' => 'can:admin'
], function () {
    Route::view('/dashboard', 'admin.home')->name('dashboard');
    Route::get('/list-of-managers', 'Admin\ManagerController@listOfManagers')->name('list-of-managers');
    Route::get('/list-of-reviewers', 'Admin\ReviewerController@listOfReviewers')->name('list-of-reviewers');
    Route::get('/list-of-categories', 'Admin\CategoryController@listOfCategories')->name('list-of-categories');
    Route::resource('manager','Admin\ManagerController');
    Route::resource('category','Admin\CategoryController');
    Route::resource('reviewer','Admin\ReviewerController');
});

/*
 * manager routes
 * */
Route::group([
    'as' => 'manager.',
    'prefix' => 'manager',
    'middleware' => 'can:manager'
], function () {
    Route::view('/dashboard', 'home')->name('dashboard');
});

/*
 * reviewer routes
 * */
Route::group([
    'as' => 'reviewer.',
    'prefix' => 'reviewer',
    'middleware' => 'can:reviewer'
], function () {
    Route::view('/dashboard', 'home')->name('dashboard');
});

Route::group([
    'as' => 'user.',
    'prefix' => 'user',
    'middleware' => 'can:user'
], function () {
    Route::post('/upload','User\JournalController@store')->name('upload');
    Route::view('/dashboard', 'home')->name('dashboard');
    Route::resource('journal','User\JournalController');
});


