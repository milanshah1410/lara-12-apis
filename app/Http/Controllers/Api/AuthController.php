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
     * This is summary.
     *
     * This is a description. In can be as large as needed and contain `markdown`.
     *
     */
    #[BodyParameter('email', default: 'test@example.com', example: 'user@example.com')]
    #[BodyParameter('password', default: 'password', example: 'string')]

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
