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

Route::redirect('/', '/login');
//Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

/*
 * Admin routes
 * */
Route::group([
    'as' => 'admin.',
    'prefix' => 'admin',
    'middleware' => ['auth','can:admin']
], function () {
	Route::get('/journals/approved','Admin\UserController@jouranlApproved')->name('journals-approved');
	Route::get('/journals/waiting','Admin\UserController@jouranlWaiting')->name('journals-waiting');
	Route::get('/journals/rejected','Admin\UserController@jouranlRejected')->name('journals-rejected');
	Route::get('/journals/journals-pie','Admin\UserController@journalPie')->name('journals-pie');
    Route::get('/dashboard', 'Admin\UserController@dashboard')->name('dashboard');
    Route::get('/list-of-managers', 'Admin\ManagerController@listOfManagers')->name('list-of-managers');
    Route::get('/list-of-reviewers', 'Admin\ReviewerController@listOfReviewers')->name('list-of-reviewers');
    Route::get('/list-of-categories', 'Admin\CategoryController@listOfCategories')->name('list-of-categories');
    Route::get('/list-of-users', 'Admin\UserController@listOfusers')->name('list-of-users');
	Route::view('/show-approved-journals','admin.approvedFiles')->name('show-approved-journals');
    Route::get('/approved-journals','Admin\UserController@approvedJournals')->name('approved-journals');

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
    Route::get('/dashboard','Manager\ListingController@listOfFiles')->name('dashboard');
    Route::put('journal/assign', 'Manager\ListingController@assignJournal')->name('assign-journal');
    Route::get('journal/{id}/assign', 'Manager\ListingController@showJournal')->name('show-journal');
    Route::get('/list-of-files','Manager\ListingController@listOfFiles')->name('list-of-files');
    Route::view('/show-approved-journals','manager.listOfApprovedFile')->name('show-approved-journals');
    Route::get('/approved-journals','Manager\ListingController@approvedJournals')->name('approved-journals');
    Route::get('/show-staffs','Manager\ListingController@showStaff')->name('show-staffs');
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
    Route::resource('journal', 'Reviewer\JournalController');
    Route::get('/my-work/{status}','Reviewer\JournalController@myWorkStats')->name('my-work');

});

Route::group([
    'as' => 'user.',
    'prefix' => 'user',
    'middleware' => ['auth','can:user']
], function () {
    Route::get('final-document/{journal}','User\JournalController@showFinalDocument')->name('final-doc');
    Route::post('final-document','User\JournalController@storeFinalDocument')->name('store-final-doc');
    Route::get('razorpay/{url}', 'RazorpayController@razorpay')->name('razorpay');
    Route::post('razorpaypayment', 'RazorpayController@payment')->name('payment');
    Route::get('/dashboard', 'User\JournalController@dashboard')->name('dashboard');
    Route::post('/upload-journal','User\JournalController@storeJournal')->name('upload');
    Route::get('/journals/{status?}','User\JournalController@index')->name('journal.index');
    Route::resource('journal','User\JournalController');
});


