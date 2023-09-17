<?php

namespace App\Services;

use App\Models\Period;
use App\Models\Role;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;


class StudentService
{
    /**
     * @param $request
     * @param $userService
     * 1. Creates a user
     * 2. Creates a student with the user id
     * @return mixed
     */
    public function create($request, $userService) {
        $user = $userService->create($request['user']);
        $student = Student::create([
            'user_id' => $user->id,
            'grade' => $request['grade']
        ]);

        return $student;
    }

    /**
     * @param int $id
     * @param object $request
     * 1. Finds student by id
     * 2. Updates data in students table
     * 3. Finds user by id from students table, user_id column
     * 4.Updates the user data
     * @return mixed
     */
    public function edit(int $id, object $request)
    {
        $student = Student::findOrFail($id);
        $student->grade = $request['grade'];
        $student->save();

        $user = User::findOrFail($student->user_id);
        $user->update([
            'user_name' => $request['user']['user_name'],
            'full_name' => $request['user']['full_name'],
            'role_id' => $request['user']['role_id']
        ]);

        return $student->with('user');
    }

    /**
     * @param int $id
     * 1. Finds student by id
     * 2. Gets from this object user id
     * 3. Deletes the user
     * 4. Deletes the student
     * @return mixed
     */
    public function delete(int $id){
        $student = Student::findOrFail($id);
        User::where('id', $student->user_id)->delete();
        $student->delete();
    }


    /**
     * @param int $id
     * Gets all students by a specific period
     * @return \Illuminate\Support\Collection
     */
    public function fetchAllByPeriod(int $id){
        return DB::table('periods')
            ->where('periods.id', $id)
            ->whereNull('periods.deleted_at')
            ->join('student_periods', 'student_periods.period_id', '=', 'periods.id')
            ->get();
    }

    /**
     * @param $request
     * Gets all students by specific period and specific teacher
     * @return \Illuminate\Support\Collection
     */
    public function fetchAllByPeriodAndByTeacher($request){
        return DB::table('students')
            ->leftJoin('student_periods', 'student_periods.period_id', '=','students.id')
            ->leftJoin('periods', 'student_periods.period_id', '=','periods.id')
            ->where('student_periods.period_id', $request['period_id'])
            ->where('periods.teacher_id', $request['teacher_id'])
            ->whereNull('periods.deleted_at')
            ->get();
    }
}
