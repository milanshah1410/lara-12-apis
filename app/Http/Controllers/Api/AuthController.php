<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Dedoc\Scramble\Attributes\BodyParameter;

class AuthController extends Controller
{
    /**
     * Login User.
     *
     * Authenticates a user using email and password credentials.
     * Returns an access token upon successful authentication.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    #[BodyParameter('email', default: 'test@example.com')]
    #[BodyParameter('password', default: 'password')]

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $user = User::where('email', $request->email)->first();

        return response()->json([
            'token' => $user->createToken('API Token')->plainTextToken,
            'user' => $user,
        ]);
    }
}
