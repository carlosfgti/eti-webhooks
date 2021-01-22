<?php

namespace App\Http\Controllers\Webhooks;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use App\Notifications\NewEnrollment;
use App\Notifications\NewUserCreated;
use App\Notifications\UserChargeback;
use App\Notifications\UserDisputeEnrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HotmartController extends Controller
{
    public function newSale(Request $request)
    {
        // If request is subscription, ignore
        if ($request->has('name_subscription_plan')) {
            return response()->json(['message' => 'not_processed_eti']);
        }

        // Get Course
        if (!$course = Course::where('identificador_hotmart', $request->prod)->with('bonus')->first()) {
            Log::info('Course Not Found', $request->toArray());
            return response()->json(['error' => 'Course Not Found'], 404);
        }

        // Get All Bonus this Course
        $bonus = $course->bonus;

        // Check Exists User
        if (!$user = User::where('email', $request->email)->first()) {
            if ($request->status != 'approved') {
                return response()->json(['message' => "User Not Exists And Status: {$request->status}"]);
            }

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

        if ($request->status != 'approved') {
            // Cancel enrollments and delete user
            return $this->cancelEnrollments($request->status, $user, $course);
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

    public function cancelEnrollments(String $status, User $user, Course $course)
    {
        // Delete all enrollments
        Enrollment::where('id_especializacao', $course->id)
                    ->where('id_user', $user->id)
                    ->delete();

        // Delete all bonus
        foreach ($course->bonus as $courseBonus) {
            Enrollment::where('id_especializacao', $courseBonus->id)
                    ->where('id_user', $user->id)
                    ->delete();
        }

        if ($status == 'chargeback') {
            $user->notify(new UserChargeback($course));
        } else if ($status == 'dispute') {
            $user->notify(new UserDisputeEnrollment($course));
        }

        $user->delete();

        return response()->json(['message' => 'Success - User Removed']);
    }
}
