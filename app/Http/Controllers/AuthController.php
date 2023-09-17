<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Validator;

class AuthController extends Controller
{
    const TOKEN_NAME = 'personal';
    /**
     * @param UserRequest $request
     * @param UserService $userService
     * 1. Creates a user
     * 2. Creates an access token for the user, allowing to him to
     * access protected endpoints in the API
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(UserRequest $request, UserService $userService)
    {
        $user = $userService->create($request);
        $token = $user->createToken(self::TOKEN_NAME)->accessToken;

        return response()->json(['token' => $token], 201);
    }

    /**
     * @param Request $request
     * 1. Validates the user
     * 2. Checks if the provided 'user_name'
     * 3. If authentication is successful it retrieves the authenticated user using Auth::user()
     * 4. Generates an access token for the user using the createToken method and assigns it
     * to the 'token' key in the $success array
     * and 'password' match a user's credentials in the application's authentication system
     * @return \Illuminate\Http\JsonResponse
     *
     */
    public function login(Request $request)
    {
        $request->validate([
            'user_name' => 'required|string',
            'password' => 'required|string',
        ]);


        if (Auth::attempt(['user_name' => $request->user_name, 'password' => $request->password])) {
            $user = Auth::user();
            $success['token'] =  $user->createToken(self::TOKEN_NAME)->accessToken;
            $success['name'] =  $user->name;

            return response()->json(['token'=>[$success['token'], 'message'=>Lang::get('messages.success.login')]]);
        } else {
            return response()->json(['error' => Lang::get('messages.error.login')], 401);
        }
    }

    /**
     *  Directly accesses the currently authenticated user
     * @return \Illuminate\Http\JsonResponse
     */
    public function user()
    {
        $user = Auth::user();
        return response()->json(['user' => $user], 200);
    }
}
