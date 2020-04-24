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

// Vocabulary
Route::get('vocabulary', 'VocabularyController@index')->name('vocabulary.index');

// Study section
Route::prefix('study/')->name('study.')->group(function(){
    Route::get('vocabulary_lesson', "StudyController@vocabularyLesson")->name('lesson');
    Route::get('vocabulary_review', 'StudyController@vocabularyReview')->name('review');
});

Route::prefix('learning_path/')->name('learningpath.')->group(function(){
    Route::prefix('vocab/')->name('vocab.')->group(function(){
        Route::get('', 'LearningPathController@index')->name('index');
        Route::get('/{level}/edit', 'LearningPathController@viewLevel')->name('edit');

        Route::get('export', "LearningPathController@export")->name('export');
    });
});

Route::prefix('account/')->name('account.')->group(function(){
    Route::get('profile/', 'AccountController@profile')->name('profile.index');
    Route::post('profile/', 'AccountController@updateProfile')->name('profile.update');

    Route::get('learning/', 'AccountController@learning')->name('learning.index');
    Route::get('payment/', 'AccountController@payment')->middleware('isRole:student')->name('payment.index');
});

Route::prefix('video_lesson/')->name('video_lesson.')->group(function(){
    Route::get("/", "VideoLessonController@index")->middleware('isRole:teacher')->name('index');
    Route::post("/update-info", "VideoLessonController@updateInformation")->middleware("isRole:teacher")->name('updateInfo');
    Route::get('/schedule', "VideoLessonController@scheduleLesson")->middleware('isRole:student')->name('schedule.index');
    Route::post('/schedule', "VideoLessonController@scheduleLessonSave")->middleware('isRole:student')->name('schedule.save');
});
