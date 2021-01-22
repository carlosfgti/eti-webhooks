<?php

namespace App\Http\Controllers\Webhooks;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use App\Notifications\NewEnrollment;
use App\Notifications\NewUserCreated;
use Illuminate\Http\Request;

class HotmartController extends Controller
{
    public function releaseStudentRegistration(Request $request)
    {
        // TMP Validation
        if ($request->hottok != env('HOTMART_TOKEN')) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        // If request is subscription, ignore
        if ($request->has('name_subscription_plan')) {
            return response()->json(['message' => 'not_processed_eti']);
        }

        // Get Course
        if (!$course = Course::where('identificador_hotmart', $request->prod)->with('bonus')->first()) {
            return response()->json(['error' => 'Course Not Found'], 404);
        }

        // Get All Bonus this Course
        $bonus = $course->bonus;

        // Check Exists User
        if (!$user = User::where('email', $request->email)->first()) {
            $password = generatePassword();
            // Create new student
            $user = User::create([
                'tipo' => 'usuario',
                'nome' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($password),

            ]);

            $user->notify(new NewUserCreated($password, $user, $course));
        }

        if ($this->userEnrollmentInCourse($user, $course)) {
            return response()->json(['message' => 'User Has Enrollment in This Course'], 200);
        }

        $enrollment = Enrollment::create([
            'id_user' => $user->id_user,
            'id_especializacao' => $course->id,
            'purchase_date' => date('Y-m-d'),
            'payment_type' => $request->payment_type,
            'status' => $request->status,
            'liberado' => 'S',
            'id_plano' => 1,
        ]);

        foreach ($bonus as $courseBonus) {
            // Check if user not is Enrollment in This Course
            if (!$this->userEnrollmentInCourse($user, $courseBonus)) {
                Enrollment::create([
                    'id_user' => $user->id_user,
                    'id_especializacao' => $courseBonus->id,
                    'purchase_date' => date('Y-m-d'),
                    'payment_type' => $request->payment_type,
                    'status' => $request->status,
                    'liberado' => 'S',
                    'id_plano' => 1,
                ]);
            }
        }

        $user->notify(new NewEnrollment($user, $course));

        return response()->json(['message' => 'Success']);
    }

    public function userEnrollmentInCourse(User $user, Course $course)
    {
        $enrollment = Enrollment::where('id_user', $user->id)
                                    ->where('id_especializacao', $course->id)
                                    ->first();

        return $enrollment;
    }
}
