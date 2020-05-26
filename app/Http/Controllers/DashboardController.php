<?php

namespace App\Http\Controllers;

use App\Helpers\VideoConferenceHelper;
use App\Models\User;
use Aws\Chime\ChimeClient;
use Carbon\Carbon;
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

        $funcName = "index_$role";
        return $this->$funcName($user, $request);
    }

    public function index_admin(User $user, Request $request){
        return view("app.dashboard_admin", compact('user'));
    }

    public function index_teacher(User $user, Request $request){
        return view("app.dashboard_teacher", compact('user'));
    }

    public function index_Student(User $user, Request $request){
        $doneBasicKanas = $user->info->information->finishedKanas();
        $nextAppointments = $user->info->information->appointments()
            ->where('date', '>=', Carbon::now())->get();

        return view("app.dashboard_student", compact('user', 'doneBasicKanas', 'nextAppointments'));
    }
}
