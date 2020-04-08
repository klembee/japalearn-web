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

Auth::routes();

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

// Users
Route::prefix('users/')->group(function(){
    Route::get('/', 'UsersController@index')->name('users.index');
    Route::get('/create', 'UsersController@create')->name('users.create');
    Route::post('/create', 'UsersController@store')->name('users.store');
});


// Students
Route::get('/students', 'StudentsController@index')->name('students.index');

// Teachers
Route::get('/teachers', 'TeachersController@index')->name('teachers.index');
Route::get('/join-teacher', 'StudentInvitationController@joinTeacher')->name('join-teacher');

// Dictionary
Route::get('dictionary', 'DictionaryController@index')->name('dictionary.index');
