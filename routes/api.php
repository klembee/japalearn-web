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

Route::post('login', 'Api\AuthController@login');
Route::post('register', 'Api\AuthController@register');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('email-list/add', 'Api\EmailListController@add')->name('email-list.add');

Route::prefix('frontpage')->name('api.frontpage.')->group(function(){
    Route::get('latest-articles', 'Api\FrontPageController@latestArticles')->name('latest.articles');
    Route::get('random-grammar-items', 'Api\FrontPageController@randomGrammarLessons')->name('random.grammar');
    Route::post('contact-us', 'Api\FrontPageController@contactUs')->name('contactus');
});

Route::middleware('auth:api')->name('api.')->group(function(){
    Route::name('teachers.')->prefix('teacher')->group(function(){
        Route::get('/generate_invite_code', "Api\TeacherController@generate_invite_code")->name('generate_invite_code');
    });

    Route::name('dictionary.')->prefix('dictionary')->group(function(){
        Route::post('/query', "Api\DictionaryController@query")->name('query');
    });

    Route::name('vocabulary.')->prefix('vocabulary')->group(function(){
        Route::post('/add', 'Api\DictionaryController@addToVocabulary')->name('add');
    });

    Route::name('chat.')->prefix('chat')->group(function(){
        Route::get('conversations', "Api\ChatController@getConversations")->name('get_conversations');
        Route::post('send', 'Api\ChatController@sendMessage')->name('send');
    });

    Route::name('dashboard.')->prefix('dashboard')->group(function(){
        Route::get('vocabSizePerDayThisMonth', 'Api\DashboardController@vocabSizePerDayThisMonth')->name('vocab_size');
        Route::get('latest_activity', 'Api\DashboardController@latestActivity')->name('latest_activity');
    });

    Route::name('blog.')->prefix('blog')->group(function(){
        Route::post('save', "Api\BlogController@save")->middleware("isRole:admin")->name('save');
    });

    Route::name('learning_path.')->prefix('learning_path')->group(function(){
        Route::prefix('kanji')->name('kanji.')->group(function(){
            Route::prefix('items')->name('items.')->group(function(){
                Route::post('create', 'Api\LearningPathController@newItem')->middleware('isRole:admin')->name('store');
                Route::post('{item}/delete', 'Api\LearningPathController@deleteItem')->middleware('isRole:admin')->name('delete');
                Route::post('{item}/update', 'Api\LearningPathController@updateItem')->middleware('isRole:admin')->name('update');

                Route::name('review.')->prefix('review')->middleware('isRole:student')->group(function(){
                    Route::post('update_level', 'Api\LearningPathController@updateLevel')->name('update_level');
                });

                Route::get('level-overview', 'Api\LearningPathController@getLevelOverview')->middleware('isRole:student')->name('level_overview');
            });
        });

        Route::prefix('kana')->name('kana.')->group(function(){
            Route::prefix('admin')->name('admin.')->middleware('isRole:admin')->group(function(){
                Route::post('{kana}/update', 'Api\KanaLearningPathController@update')->name('update');
            });

            Route::name('review.')->prefix('review')->group(function(){
                Route::post('update_level', 'Api\KanaLearningPathController@updateLevel')->name('update_level');
            }) ;
        });

        Route::prefix('grammar')->name('grammar.')->group(function(){
            Route::prefix('admin')->name('admin.')->middleware('isRole:admin')->group(function() {
                Route::post('create', 'Api\GrammarLearningPathController@addGrammarLesson')->name('store');
                Route::post('update/{item}', 'Api\GrammarLearningPathController@updateGrammarLesson')->name('update');

                Route::post('question/delete', 'Api\GrammarLearningPathController@deleteQuestion')->name('question.delete');
            });

            Route::post('update-level', 'Api\GrammarLessonController@updateLevel')->middleware('isRole:student')->name('update-level');
        });

        Route::prefix('stories')->name('stories.')->group(function(){
            Route::prefix('admin')->name('admin.')->middleware('isRole:admin')->group(function() {
                Route::post('create-update', 'Api\StoriesController@createUpdate')->name('createupdate');
                Route::post('create-author', 'Api\AuthorController@create')->name('create_author');
            });
        });

    });

    Route::name('video_lesson.')->prefix('video_lesson')->group(function(){
        Route::post('update_availability', 'Api\VideoLessonController@updateAvailability')->middleware('isRole:teacher')->name('updateAvailability');
        Route::post('confirm_lesson/{lesson}', 'Api\VideoLessonController@confirmLesson')->middleware('isRole:teacher')->name('confirm');
        Route::get('fetch_availability', 'Api\VideoLessonController@fetchAvailabilities')->name('fetchAvailability');
        Route::post('fetch_availability_for_date', 'Api\VideoLessonController@fetchAvailabilitiesForDate')->name('fetchAvailabilityDate');
        Route::post('schedule', 'Api\VideoLessonController@scheduleWithTeacher')->middleware('isRole:student')->name('schedule');
    });

    Route::name('appointment.')->prefix('appointment')->group(function(){
        Route::get('upcoming_appointments', 'Api\AppointmentController@listUpcomingAppointments')->name('upcoming');
    });

    Route::name('payment.')->prefix('payment')->middleware('isRole:student')->group(function(){
        Route::post('add-payment-method', 'Api\PaymentController@addPaymentMethod')->name('add-payment-method');
        Route::post('delete-payment-method', 'Api\PaymentController@deletePaymentMethod')->name('delete-payment-method');
        Route::post('subscribe', 'Api\PaymentController@subscribe')->name('subscribe');
        Route::post('unsubscribe', 'Api\PaymentController@unsubscribe')->name('unsubscribe');
    });
});
