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

// Just for testing purposes
Route::get('mailable', function () {
    return new \App\Mail\AskStudentForTeacherRecommendation(\App\Models\Appointment::query()->first());
});

Route::post("/get-notified", "EmailListController@add");

Auth::routes(['verify' => true]);

Route::name('frontpage.')->group(function(){
    Route::get('/', 'FrontPageController@home')->name('home');
    Route::get('/grammar-items', 'FrontPageController@grammar')->name('grammar');
    Route::get('/grammar-items/{item}', 'FrontPageController@viewGrammar')->name('grammar.view');
    Route::get('/grammar-items/category/{category}', 'FrontPageController@grammarCategory')->name('grammar.category');
    Route::get('/stories', 'FrontPageController@stories')->name('stories');
    Route::get('/stories/read/{story}', 'FrontPageController@readStory')->name('story.read');
    Route::get('/blog', 'FrontPageController@blog')->name('blog');
    Route::get('/blog/{post}', 'FrontPageController@viewArticle')->name('blog.view');

    Route::get('/privacy-policy', 'FrontPageController@privacyPolicy')->name('privacyPolicy');
    Route::get('/terms-and-conditions', 'FrontPageController@termsConditions')->name('termsAndConditions');
});

Route::middleware('auth')->group(function(){
    Route::post('resend-verifications', 'AccountController@resendConfirmation')->name('resend_confirmation');

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

    Route::prefix('blog_admin/')->name('blog.')->middleware('isRole:admin')->group(function(){
        Route::get('/', 'BlogController@index')->name('index');
        Route::get('/create', 'BlogController@create')->name('create');
        Route::get('/edit/{post}', 'BlogController@edit')->name('edit');
    });

    Route::prefix('learning_path/')->name('learning_path.')->middleware('isRole:admin')->group(function(){
        Route::prefix('stories/')->name('stories.')->group(function(){
            Route::get('', 'StoriesController@indexAdmin')->name('index');
            Route::get('create/', 'StoriesController@create')->name('create');
            Route::get('edit/{story}', 'StoriesController@edit')->name('edit');
            Route::get('delete/{story}', 'StoriesController@delete')->name('delete');
        });

        Route::prefix('kana/')->name('kana.')->group(function(){
            Route::get('', 'KanaLearningPathController@index')->name('index');
        });

        Route::prefix('vocab/')->name('vocab.')->group(function(){
            Route::get('', 'KanjiLearningPathController@index')->name('index');
            Route::get('/{level}/edit', 'KanjiLearningPathController@viewLevel')->name('edit');

            Route::get('export', "KanjiLearningPathController@export")->name('export');
        });

        Route::prefix('grammar/')->name('grammar.')->group(function(){
            Route::get('', 'GrammarLearningPathController@index')->name('index');
            Route::get('/lesson/{item}', 'GrammarLearningPathController@edit')->name('edit');
            Route::post('/lesson/{item}', 'GrammarLearningPathController@update')->name('update');
            Route::get('/category/{category}', 'GrammarLearningPathController@viewCategory')->name('view_category');
        });
    });

    Route::prefix('account/')->name('account.')->group(function(){
        Route::get('preferences/', 'AccountController@preferences')->name('preferences.index');
        Route::post('preferences/', 'AccountController@updatePreferences')->name('preferences.update');

        Route::get('profile/', 'AccountController@profile')->name('profile.index');
        Route::post('profile/', 'AccountController@updateProfile')->name('profile.update');

        Route::get('email_preferences/', 'AccountController@emailPreferences')->name('emails.index');
        Route::post('email_preferences/', 'AccountController@updateEmailPreferences')->name('emails.update');

        Route::get('learning/', 'AccountController@learning')->middleware('isRole:student')->name('learning.index');
        Route::get('payment/', 'AccountController@payment')->middleware('isRole:student')->name('payment.index');

        Route::get('subscription/', 'AccountController@subscription')->middleware('isRole:student')->name('subscription.index');
        Route::post('subscription/', 'AccountController@updateSubscription')->middleware('isRole:student')->name('subscription.update');

        Route::get('unsubscribe/', 'AccountController@unsubscribeIndex')->middleware('isRole:student')->name('unsubscribe');


        // ------- Teachers
        Route::get('get-paid', 'AccountController@getPaidIndex')->middleware('isRole:teacher')->name('getpaid.index');
        Route::post('get-paid', 'AccountController@updateGetPaid')->middleware('isRole:teacher')->name('getpaid.update');
    });

    Route::prefix('stripe/')->name('stripe.')->middleware('isRole:teacher')->group(function(){
        Route::get('teacher_redirect', 'StripeController@teacherSetupRedirect');
    });

    Route::prefix('video_lesson/')->name('video_lesson.')->group(function(){
        Route::get("/", "VideoLessonController@index")->middleware('isRole:teacher')->name('index');
        Route::post("/update-info", "VideoLessonController@updateInformation")->middleware("isRole:teacher")->name('updateInfo');
        Route::get('refuse/{appointment}', 'VideoLessonController@teacherRefuseAppointment')->middleware('isRole:teacher')->name('refuse');
        Route::get('confirm/{appointment}', 'VideoLessonController@teacherConfirmAppointment')->middleware('isRole:teacher')->name('confirm');

        Route::get('/schedule/{teacher}', "VideoLessonController@scheduleLesson")->middleware('isRole:student')->name('schedule.index');
        Route::post('/schedule', "VideoLessonController@scheduleLessonSave")->middleware('isRole:student')->name('schedule.save');

        Route::get('/rate-video-lesson/{appointment}', 'VideoLessonController@rateLesson')->middleware('isRole:student')->name('rate_appointment');
    });

// Kanas
    Route::prefix('kanas/')->name('kanas.')->group(function(){
        Route::get('/', 'KanaController@index')->name('index');
    });

// Kanji and vocabulary
    Route::prefix('kanji_vocabulary/')->name('kanji_vocabulary.')->group(function(){
        Route::get('/', "KanjiVocabularyController@index")->name('index');
    });

// Grammar
    Route::prefix('grammar/')->name('grammar.')->group(function(){
        Route::get('/', 'GrammarController@index')->name('index');
        Route::get('/learn/{item}', 'GrammarController@learn')->name('learn');
    });

// Reading
    Route::prefix('reading/')->name('reading.')->group(function(){
        Route::get('/', 'ReadingController@index')->name('index');
    });

    // Stories
    Route::prefix('stories/')->name('stories.')->group(function(){
        Route::get('{story}/', 'StoriesController@read')->name('read');
    });

// listening
    Route::prefix('listening/')->name('listening.')->group(function(){
        Route::get('/', 'ListeningController@index')->name('index');
    });

    Route::prefix("conference/")->name('conference.')->group(function(){
        Route::get('/', 'ConferenceController@index')->name('index');
        Route::get('/join/{appointment}', 'ConferenceController@join')->name('join');
    });

    // Study section
    Route::prefix('study/')->name('study.')->group(function(){
        // Kana
        Route::get('kana_lesson', 'KanaStudyController@lesson')->name('kana.lesson');
        Route::get('kana_review', 'KanaStudyController@review')->name('kana.review');

        // Vocab
        Route::get('vocabulary_lesson', "VocabularyStudyController@vocabularyLesson")->name('vocab.lesson');
        Route::get('vocabulary_review', 'VocabularyStudyController@vocabularyReview')->name('vocab.review');

        // Grammar
        Route::get('grammar_lesson/{grammarlesson}', "GrammarController@review")->name('grammar.review');

    });
});
