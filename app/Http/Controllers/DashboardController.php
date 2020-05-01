<?php

namespace App\Http\Controllers;

use App\Helpers\VideoConferenceHelper;
use Aws\Chime\ChimeClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Uuid;

/**
 * This is the controller class for tasks relating the Dashboard
 * Class DashboardController
 * @package App\Http\Controllers
 */
class DashboardController extends Controller
{
    /**
     * Checks that the user is authenticated before accessing this page
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Shows the application dashboard.
     * The view that is showing depends on the role of the logged in user.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $role = $user->role->name;

        return view("app.dashboard_$role", compact('user'));
    }
}
