<?php

namespace App\Services;

use App\Models\Role;
use App\Models\Student;
use App\Models\User;


class UserService
{
    /**
     * @param $request
     * @return mixed
     */
    public function create($request) {
        $role = Role::where('id', $request['role_id'])->first();
        $user = User::create([
            'user_name' => $request['user_name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
            'full_name' => $request['full_name'],
            'role_id' => $role->id
        ]);

        return $user;
    }

    /**
     * @param $request
     * @param int $id
     * @return mixed
     */
    public function update($request, int $id){
        $user = User::findOrFail($id);
        $user->update([
            'user_name' => $request['user_name'],
            'full_name' => $request['full_name'],
            'role_id' => $request['role_id']
        ]);

        return $user;
    }
}
