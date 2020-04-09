<?php


namespace App\Http\Controllers;


use App\Models\StudentInvitation;
use App\Policies\StudentInvitationPolicy;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class StudentInvitationController extends Controller
{
    public function joinTeacher(Request $request){
        $this->validate($request, [
            'code' => 'present'
        ]);

        $code = $request->get('code');
        $invitation = StudentInvitation::query()->where('code', $code)->first();

        if(!$invitation || !$invitation->isValid()){
            $request->session()->flash('message', __('The invitation code provided is not valid'));
            return redirect(route('dashboard'));
        }

        $loggedin_user = $request->user();
        if(!$loggedin_user){
            // Ask the user to login again
            // After the login, he will be redirected here
            return redirect(route('login', ['after-login' => $request->fullUrl()]));
        }


        // If logged in, check if the user can join the teacher
        try{
            $this->authorize('joinTeacher', $invitation);
        }catch (AuthorizationException $e){
            $response = $e->response();
            if($response->denied()){
                if($response->code() == StudentInvitationPolicy::$NOT_STUDENT_CODE){
                    // The user is not a student, log out and allow to login again
                    $request->session()->flash('message', $response->message());

                    Auth::logout();
                    return redirect(route('login', ['after-login' => $request->fullUrl()]));
                }else if($response->code() == StudentInvitationPolicy::$ALREADY_STUDENT_CODE){
                    // The student is already a student of this teacher, redirect to dashboard
                    $request->session()->flash('message', $response->message());
                    return redirect('dashboard');
                }
            }else{
                $request->session()->flash('message', __("Cannot join this teacher."));
                return redirect('dashboard');
            }
        }

        // The user successfully joined the teacher
        $teacher = $invitation->teacher;
        $teacher->students()->attach($request->user()->id);

        // Make them both friends
        $teacher->friends()->attach($request->user()->id);
        $loggedin_user->friends()->attach($teacher->id);

        return redirect('dashboard');
    }
}
