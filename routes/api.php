<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->name('api.')->group(function(){
    Route::name('teachers.')->prefix('teacher')->group(function(){
        Route::get('/generate_invite_code', "Api\TeacherController@generate_invite_code")->name('generate_invite_code');
    });

    Route::name('dictionary.')->prefix('dictionary')->group(function(){
        Route::post('/query', "Api\DictionaryController@query")->name('query');
    });

    Route::name('vocabulary.')->prefix('vocabulary')->group(function(){
        Route::post('/add', 'Api\VocabularyController@add')->name('add');
    });

    Route::name('chat.')->prefix('chat')->group(function(){
        Route::get('conversations', "Api\ChatController@getConversations")->name('get_conversations');
        Route::get('fetch', 'Api\ChatController@fetchMessages')->name('fetch');
        Route::post('send', 'Api\ChatController@sendMessage')->name('send');
    });
});
