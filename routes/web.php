<?php

use App\User;
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
    'middleware' => ['auth','can:admin']
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
    'middleware' => ['auth','can:manager']
], function () {
    Route::put('journal/assign', 'Manager\ListingController@assignJournal')->name('assign-journal');
    Route::get('journal/{id}/assign', 'Manager\ListingController@showJournal')->name('show-journal');
    Route::view('/dashboard', 'manager.listofFiles')->name('dashboard');
    Route::get('/show-files','Manager\ListingController@showFiles')->name('show-files');
    Route::get('/list-of-files','Manager\ListingController@listOfFiles')->name('list-of-files');
    Route::get('/show-staffs','Manager\ListingController@showStaff')->name('show-staffs');
    Route::get('/list-of-staffs','Manager\ListingController@listOfStaff')->name('list-of-staffs');
});

/*
 * reviewer routes
 * */
Route::group([
    'as' => 'reviewer.',
    'prefix' => 'reviewer',
    'middleware' => ['auth','can:reviewer']
], function () {
    Route::view('/dashboard', 'home')->name('dashboard');
});

Route::group([
    'as' => 'user.',
    'prefix' => 'user',
    'middleware' => ['auth','can:user']
], function () {
    Route::view('/dashboard', 'user.home')->name('dashboard');
    Route::post('/upload-journal','User\JournalController@storeJournal')->name('upload');
    Route::resource('journal','User\JournalController');
});


