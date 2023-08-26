<?php

namespace App\Http\Controllers;

use App\Models\Period;
use App\Models\Student;
use App\Services\UserService;
use Illuminate\Http\Request;
use App\Http\Requests\StudentRequest;
use App\Services\StudentService;

class StudentController extends Controller
{
    /**
     * @param StudentRequest $request
     * @param StudentService $studentService
     * @param UserService $userService
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(StudentRequest $request, StudentService $studentService, UserService $userService) {
        $student = $studentService->create($request, $userService);

        return response()->json($student->fresh());
    }

    /**
     * @param int $id
     * @param StudentRequest $request
     * @param StudentService $studentService
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(int $id, StudentRequest $request, StudentService $studentService){
        $student = $studentService->edit($id, $request);


        return response()->json($student, 200);
    }

    /**
     * @param $id
     * @param StudentService $studentService
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(int $id, StudentService $studentService) {
        $student = $studentService->delete($id);

        return response()->json($student, 200);
    }


    /**
     * @param int $id
     * @param StudentService $studentService
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchAllByPeriod(int $id, StudentService $studentService){
        $students = $studentService->fetchAllByPeriod($id);

        return response()->json($students);
    }

    /**
     * @param Request $request
     * @param StudentService $studentService
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchAllByPeriodAndByTeacher(Request $request, StudentService $studentService){
        $students = $studentService->fetchAllByPeriodAndByTeacher($request);

        return response()->json($students);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addStudentToPeriod(Request $request){
        $student = Student::findOrFail($request['student_id']);
        $student->periods()->attach($request['period_id']);

        return response()->json('Student has been added successfully to the period', 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeStudentToPeriod(Request $request){
        $student = Student::findOrFail($request['student_id']);
        $student->periods()->detach($request['period_id']);
        return response()->json('Student has been removed successfully from the period', 200);
    }
}
