<?php

namespace App\Http\Controllers\Authorization;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $data = $request->validated();
        if (! Auth::attempt($data)) {
            return response([
                'message' => 'Incorrect credentials',
            ]);
        }
        $user = auth()->user();
        $token = $user->createToken('API_token')->plainTextToken;

        return response(['token' => $token], 402);
    }

    public function logout(Request $request)
    {

        auth()->user()->currentAccessToken()->delete();

        return response([
            'message' => 'Logoueted',
        ], 200);
    }
}
