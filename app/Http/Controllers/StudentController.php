<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Services\UserService;
use Illuminate\Http\Request;
use App\Http\Requests\StudentRequest;
use App\Services\StudentService;
use Illuminate\Support\Facades\Lang;

class StudentController extends Controller
{
    /**
     * @param StudentRequest $request
     * @param StudentService $studentService
     * @param UserService $userService
     * Creates a new student
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(StudentRequest $request, StudentService $studentService, UserService $userService) {
        $student = $studentService->create($request, $userService);

        return response()->json($student);
    }

    /**
     * @param int $id
     * @param StudentRequest $request
     * @param StudentService $studentService
     * Updates the existing student
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(int $id, StudentRequest $request, StudentService $studentService){
        $student = $studentService->edit($id, $request);

        return response()->json($student, 200);
    }

    /**
     * @param $id
     * @param StudentService $studentService
     * Deletes the existing student
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(int $id, StudentService $studentService) {
        $student = $studentService->delete($id);

        return response()->json(Lang::get('messages.success.login',['name' => 'student']), 204);
    }


    /**
     * @param int $id
     * @param StudentService $studentService
     * Fetch all students by period id
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchAllByPeriod(int $id, StudentService $studentService){
        $students = $studentService->fetchAllByPeriod($id);

        return response()->json($students);
    }

    /**
     * @param Request $request
     * @param StudentService $studentService
     * Gets all students by period and by specific teacher
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchAllByPeriodAndByTeacher(Request $request, StudentService $studentService){
        $request->validate([
            'teacher_id' => 'required|integer',
            'period_id' => 'required|integer'
        ]);

        $students = $studentService->fetchAllByPeriodAndByTeacher($request);

        return response()->json($students);
    }

    /**
     * @param Request $request
     * Adds specific student to the specific period
     * @return \Illuminate\Http\JsonResponse
     */
    public function addStudentToPeriod(Request $request){
        $request->validate([
            'student_id' => 'required|integer',
            'period_id' => 'required|integer'
        ]);

        $student = Student::findOrFail($request['student_id']);
        $student->periods()->attach($request['period_id']);

        return response()->json(Lang::get('messages.success.add'), 200);
    }

    /**
     * @param Request $request
     * Deletes specific student from the period
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeStudentToPeriod(Request $request){
        $request->validate([
            'student_id' => 'required|integer',
            'period_id' => 'required|integer'
        ]);

        $student = Student::findOrFail($request['student_id']);
        $student->periods()->detach($request['period_id']);
        return response()->json(Lang::get('messages.success.remove'), 200);
    }
}
