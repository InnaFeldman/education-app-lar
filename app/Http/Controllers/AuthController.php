<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class AuthController extends Controller
{
    /**
     * @param UserRequest $request
     * @param UserService $userService
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(UserRequest $request, UserService $userService)
    {
        $user = $userService->create($request);
        $token = $user->createToken('personal')->accessToken;

        return response()->json(['token' => $token], 201);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        if (Auth::attempt(['user_name' => $request->user_name, 'password' => $request->password])) {
            $user = Auth::user();
            $success['token'] =  $user->createToken('personal')->accessToken;
            $success['name'] =  $user->name;

            return response()->json(['token'=>[$success['token'], 'message'=>'User login successfully.']]);
        } else {
            return response()->json(['error' => 'Unauthoriz222ed'], 401);
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function user()
    {
        $user = Auth::user();
        return response()->json(['user' => $user], 200);
    }
}
