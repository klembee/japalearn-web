<?php


namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * Controllers for the users page
 * Class UsersController
 * @package App\Http\Controllers
 */
class UsersController extends Controller
{

    /**
     * The user accessing these views must be logged in and
     * have the admin role
     * UsersController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('isRole:admin');
    }

    /**
     * Shows the list of users registered on JapaLearn
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request){
        $this->authorize('list', User::class);

        $users = User::query()->paginate(10);

        return view('app.users.index', compact('users'));
    }

    public function view(Request $request, User $user){

        if($user->isStudent()) {
            $kanjiLevel = $user->info->kanji_level;
            if($user->info->kanjiLearningPathStats->count() > 0){
                $lastKanjiReviewDate = $user->info->kanjiLearningPathStats()->orderBy('last_study_date', 'desc')->first()->last_study_date->format('Y-m-d H:i');
            }else{
                $lastKanjiReviewDate = "NIL";
            }

            if($user->info->kanaLearningPathStats->count() > 0){
                $lastKanaReviewDate = $user->info->kanaLearningPathStats()->orderBy('last_review', 'desc')->first()->last_review->format('Y-m-d H:i');
                $nbKanaLevel5 = $user->info->kanaLearningPathStats()->where('number_right', '>=', 5)->count();
            }else{
                $lastKanaReviewDate = "NIL";
                $nbKanaLevel5 = 0;
            }

            if($user->info->grammarItemsDone->count() > 0){
                $nbGrammarItemCompleted = $user->info->grammarItemsDone()->count();
                $grammarLastCompletedDate = $user->info->grammarItemsDone()->orderBy('pivot_date_done', 'desc')->first()->toArray()['pivot']['date_done'];
            }else{
                $nbGrammarItemCompleted = 0;
                $grammarLastCompletedDate = "NIL";
            }


        }

        return view('app.users.view', compact(
            'user',
            'kanjiLevel',
            'lastKanjiReviewDate',
            'lastKanaReviewDate',
            'nbKanaLevel5',
            'nbGrammarItemCompleted',
            'grammarLastCompletedDate'
        ));
    }

    /**
     * Allows an admin to create a new user
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(Request $request){
        $this->authorize('create', User::class);

        return view('app.users.create');
    }


    /**
     * Store the information of a user after the admin
     * created it using a form
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request){
        $this->authorize('create', User::class);
        $this->validate($request, [
            'name' => 'present',
            'email' => 'present|email',
            'password' => 'present'
        ]);

        $user = new User([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role_id' => Role::student()->id,
        ]);
        $user->save();

        return redirect(route('users.index'));
    }
}
