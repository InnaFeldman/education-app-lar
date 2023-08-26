<?php

namespace App\Services;

use App\Models\Teacher;
use App\Models\User;
use http\Env\Request;


class TeacherService
{
    /**
     * @param $request
     * @param $userService
     */
    public function create($request, $userService) {
        $user = $userService->create($request);
        $teacher = Teacher::create([
            'user_id' => $user->id
        ]);

        return $teacher;

    }

    /**
     * @param int $id
     * @param object $request
     * @param $userService
     */
    public function edit(int $id, $request, $userService)
    {
        $user = $userService->update($request, $id);

        return $user;
    }

    /**
     * @param int $id
     */
    public function delete(int $id){
        $teacher = Teacher::findOrFail($id);
        $user = User::where('id', $teacher->user_id)->delete();
        $teacher->delete();

        return $teacher;
    }
}
