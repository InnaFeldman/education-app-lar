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

class TeacherController extends Controller
{
    /**
     * @param UserRequest $request
     * @param TeacherService $teacherService
     * @param UserService $userService
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(UserRequest $request, TeacherService $teacherService, UserService $userService) {
        $teacher = $teacherService->create($request, $userService);

        return response()->json($teacher->fresh());
    }

    /**
     * @param int $id
     * @param TeacherRequest $request
     * @param TeacherService $teacherService
     * @param UserService $userService
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(int $id, TeacherRequest $request, TeacherService $teacherService, UserService $userService){
        $teacher = $teacherService->edit($id, $request, $userService);

        return response()->json($teacher->with('teacher'), 200);
    }

    /**
     * @param int $id
     * @param TeacherService $teacherService
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(int $id, TeacherService $teacherService) {
        $teacher = $teacherService->delete($id);

        return response()->json($teacher, 200);
    }
}
