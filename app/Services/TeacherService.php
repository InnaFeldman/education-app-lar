<?php

namespace App\Services;

use App\Models\Teacher;
use App\Models\User;
use http\Env\Request;


class TeacherService
{
    /**
     * @param $request
     * 1. Creates a user
     * 2. Creates a teacher with user_id
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
     * Updates the user
     * @param $userService
     */
    public function edit(int $id, $request, $userService)
    {
        $user = $userService->update($request, $id);

        return $user;
    }

    /**
     * @param int $id
     * 1.Finds teacher by id
     * 2. Finds user by using user_id
     * 3. Deletes user
     * 4. Delets teacher
     *
     */
    public function delete(int $id){
        $teacher = Teacher::findOrFail($id);
        User::where('id', $teacher->user_id)->delete();
        $teacher->delete();
    }
}
