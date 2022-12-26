<?php

namespace App\Services;

use App\Models\User;

class PassportAuthService
{
    public function register($request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
        return $user->createToken('Laravel9PassportAuth')->accessToken;
    }

    public function login($data)
    {
        if (auth()->attempt($data)) {
            $token = auth()->user()->createToken('Laravel9PassportAuth')->accessToken;
            return response()->json(['token' => $token], 200);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }
}
