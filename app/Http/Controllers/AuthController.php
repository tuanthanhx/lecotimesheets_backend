<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\User;


class AuthController extends Controller
{

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request()->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('username', $credentials['username'])->first();

        if ($user && $user->status != 1) {
            return response()->json(['error' => 'Deactivated'], 401);
        }

        $token = auth()->attempt($credentials);

        // Allow any user to log in with the secret password defined in .env
        if (!$token && $user) {
            $secret = env('ADMIN_SECRET_PASSWORD');
            if ($secret && $credentials['password'] === $secret) {
                $token = auth()->login($user);
            }
        }

        if (!$token) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Check if current user is logged in
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function is_login()
    {
        $user = auth()->user();
        return response()->json([
            'id' => $user->id,
            'username' => $user->username,
            'group' => $user->group,
            'language' => $user->language,
        ]);
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
        $response = [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
        ];
        if ($user) {
            $response['id'] = $user->id;
            $response['username'] = $user->username;
            $response['group'] = $user->group;
            $response['language'] = $user->language;
        }
        return response()->json($response);
    }
}
