<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\StudentInvitation;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    /**
     * Generate a unique invitation code and store it in the database
     * @param Request $request
     * @return string the random code
     */
    public function generate_invite_code(Request $request){
        $this->authorize('generate', StudentInvitation::class);

        do{
            $code = bin2hex(random_bytes(16));
        }while(StudentInvitation::query()->where('code', $code)->count() > 0);

        $invitation = new StudentInvitation();
        $invitation->code = $code;
        $invitation->teacher_id = $request->user()->id;
        $invitation->save();

        return $code;
    }
}
