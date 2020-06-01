<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function listUpcomingAppointments(Request $request){
        $user = $request->user();
        $appointments = $user->info->appointments()
            ->where('canceled', false)
            ->where('date', '>=', Carbon::now())->with(['studentInfo', 'teacherInfo', 'studentInfo.user', 'teacherInfo.user'])->get();

        return response()->json([
            'success' => true,
            'appointments' => $appointments
        ]);

    }
}
