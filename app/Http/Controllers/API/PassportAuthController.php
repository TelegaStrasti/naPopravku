<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PassportAuthRequest;
use App\Services\PassportAuthService;
use Illuminate\Http\Request;

class PassportAuthController extends Controller
{
    protected $service;

    public function __construct(PassportAuthService $service)
    {
        $this->service = $service;
    }

    /**
     * Registration Req
     */
    public function register(PassportAuthRequest $request)
    {
        return response()->json(['token' => $this->service->register($request)], 200);
    }

    /**
     * Login Req
     */
    public function login(Request $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];
        return $this->service->login($data);
    }

    public function userInfo()
    {
        $user = auth()->user();
        return response()->json(['user' => $user], 200);
    }
}
