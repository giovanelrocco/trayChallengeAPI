<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function authenticate(Request $request)
    {
        try
        {
            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);
        } catch (\Illuminate\Validation\ValidationException $th) {
            return response($th->validator->errors(), 422);
        }

        if (Auth::attempt($credentials)) {
            $request->user()->tokens()->delete();
            $token = $request->user()->createToken($credentials['email']);

            return ['token' => $token->plainTextToken];
        }

        return response()->json([
            'email' => 'The provided credentials do not match our records.',
        ], 422);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'success',
        ]);
    }

    public function me(Request $request)
    {
        $user = $request->user();

        return response()->json($user);
    }
}
