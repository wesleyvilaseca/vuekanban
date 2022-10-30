<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function auth(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => trans('messages.invalid_credentials')], 404);
        }

        $token = $user->createToken($request->email)->plainTextToken;

        return response()->json(['token' => $token]);
    }

    public function me(Request $request)
    {
        $client = $request->user();

        return new UserResource($client);
    }

    public function logout(Request $request)
    {
        $user = $request->user();

        // Revoke all tokens client...
        $user->tokens()->delete();

        return response()->json([], 204);
    }
}
