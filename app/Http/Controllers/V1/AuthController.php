<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:50',
            'password' => 'required|string'
        ]);

        $user = User::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                "message" => 'The provided credentials are incorrect.',
            ]);
        }

        $token = $user->createToken($user->username . '.token')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response()->json($response, 200);
    }

    public function logout(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json("User not authenticated", 401);
        }

        $user->tokens()->delete();
        return response()->json("Logged out", 200);
    }

    public function signIn(StoreUserRequest $request)
    {
        $data = $request->all();

        $user = User::create($data);

        $token = $user->createToken($user->username . '.token')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        //TODO: implement verification with email.

        return response()->json($response, 200);
    }
}
