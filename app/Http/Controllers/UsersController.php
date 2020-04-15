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
