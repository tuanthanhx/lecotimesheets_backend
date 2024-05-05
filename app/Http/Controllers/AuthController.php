<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Validator;


class AuthController extends Controller
{

    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    // public function register() {
    //     $validator = Validator::make(request()->all(), [
    //         'name' => 'required|string|max:255',
    //         'username' => 'required|string|unique:users',
    //         'password' => 'required|confirmed|min:6',
    //         'hourly_rate' => 'required|numeric|min:1',
    //         'dob' => 'nullable|date',
    //         'address' => 'nullable|string|max:255',
    //         'phone' => 'nullable|string|max:255',
    //         'language' => 'nullable|string',
    //         'status' => 'nullable|numeric',
    //     ]);

    //     if($validator->fails()){
    //         return response()->json($validator->errors()->toJson(), 400);
    //     }

    //     $user = new User;
    //     $user->name = request()->name;
    //     $user->username = request()->username;
    //     $user->password = bcrypt(request()->password);
    //     $user->group = 2;
    //     $user->hourly_rate = request()->hourly_rate;
    //     $user->dob = request()->dob;
    //     $user->address = request()->address;
    //     $user->phone = request()->phone;
    //     $user->language = request()->language;
    //     $user->status = request()->status;
    //     $user->save();

    //     return response()->json($user, 201);
    // }


    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['username', 'password']);

        $user = User::where('username', $credentials['username'])->first();

        if ($user && $user->status != 1) {
            return response()->json(['error' => 'Deactivated'], 401);
        }

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function is_login()
    {
        return response()->json(['logged_in' => auth()->check()]);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        $user = auth()->user();
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'name' => $user->name,
            'username' => $user->username,
            'is_admin' => $user->group == 6 ? true : false,
        ]);
    }
}
