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
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param Request $request
     */
    public function index(Request $request){
        $this->authorize('list', User::class);

        $users = User::query()->paginate(10);

        return view('app.users.index', compact('users'));
    }

    public function create(Request $request){
        $this->authorize('create', User::class);

        return view('app.users.create');
    }

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
