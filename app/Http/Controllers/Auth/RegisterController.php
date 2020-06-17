<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Kana;
use App\Models\KanaLearningStats;
use App\Models\Role;
use App\Models\StudentInfo;
use App\Models\TeacherInfo;
use App\Models\User;
use App\Models\UserInformation;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
//            'account_type' => ['required','in:student,teacher'],
            'experience_kana' => ['nullable','in:no_knowlege,full_knowledge,katakana_knowledge,hiragana_knowledge'],
            'concentration' => ['nullable','in:everything,kanjis,speaking,reading'],
            'experience_other_platform' => ['nullable','in:no,yes'],
            'country' => 'required'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = new User([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
//            'role_id' => $data['account_type'] == 'teacher' ? Role::teacher()->id : Role::student()->id
            'role_id' => Role::student()->id,
            'country' => $data['country']
        ]);

        if($user->isStudent()){
            // Create the student info if user is student

            $studentInfo = new StudentInfo();
            $studentInfo->kanji_level = 1;
            $studentInfo->grammar_level = 1;

            $studentInfo->concentration = $data['concentration'];

            if(array_key_exists('experience_other_platform', $data)){
                $studentInfo->used_other_platforms_before = $data['experience_other_platform'] === "yes";
            }

            $studentInfo->save();

            $user->information_id = $studentInfo->id;
            $user->information_type = StudentInfo::class;


            $objects = null;

            switch ($data['experience_kana']){
                case "full_knowledge":
                    $objects = Kana::all();
                    break;
                case "katakana_knowledge":
                    $objects = Kana::katakanas()->get();
                    break;
                case "hiragana_knowledge":
                    $objects = Kana::hiraganas()->get();
                    break;
            }

            if($objects != null){
                foreach ($objects as $kana){
                    $kana_student = new KanaLearningStats([
                        'student_info_id' => $studentInfo->id,
                        'kana_id' => $kana->id,
                        'number_right' => 5,
                        'last_review' => now()
                    ]);
                    $kana_student->save();
                }
            }

        }else if($user->isTeacher()){
            // Create teacher info
            $teacherInfo = new TeacherInfo();
            $teacherInfo->save();

            $user->information_id = $teacherInfo->id;
            $user->information_type = TeacherInfo::class;
        }

        $user->save();

        return $user;
    }
}
