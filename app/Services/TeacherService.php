<?php

namespace App\Services;

use App\Models\Teacher;
use App\Models\User;


class TeacherService
{
    /**
     * @param $request
     * @param $userService
     * @return mixed
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
     * @return mixed
     */
    public function edit(int $id, object $request, $userService)
    {
        $user = $userService->update($request, $id);

        return $user;
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function delete(int $id){
        $user = User::findOrFail($id);
        $teacher = Teacher::where('user_id', $user->id)->delete();
        $user->delete();

        return $teacher;
    }
}
