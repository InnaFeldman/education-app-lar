<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRequest;
use App\Http\Requests\TeacherRequest;
use App\Http\Requests\UserRequest;
use App\Rules\ExistingAndNotSoftDeleted;
use App\Services\StudentService;
use App\Services\TeacherService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class TeacherController extends Controller
{
    /**
     * @param UserRequest $request
     * @param TeacherService $teacherService
     * @param UserService $userService
     * Creates a new teacher
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(UserRequest $request, TeacherService $teacherService, UserService $userService) {
        $teacher = $teacherService->create($request, $userService);

        return response()->json($teacher);
    }

    /**
     * @param int $id
     * @param TeacherRequest $request
     * @param TeacherService $teacherService
     * @param UserService $userService
     * Updates the existing teacher
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(int $id, TeacherRequest $request, TeacherService $teacherService, UserService $userService){
        $teacher = $teacherService->edit($id, $request, $userService);

        return response()->json($teacher, 200);
    }

    /**
     * @param int $id
     * @param TeacherService $teacherService
     * Deletes the teacher
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(int $id, TeacherService $teacherService) {
        $teacher = $teacherService->delete($id);

        return response()->json(Lang::get('messages.success.login',['name' => 'teacher']), 204);
    }
}
