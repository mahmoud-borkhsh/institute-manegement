<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthManager extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => ['required','exist:Managers'],
            'password' => ['required']
        ]);
        if ($validator->fails())
            return $this->handleResponse(null, $validator->errors()->first(), 400);

        try {
            $token = auth('manager')->attempt($request->only('mobile', 'password'));
            if (!$token) {
                return $this->handleResponse(null, "wrong mobile or password", 400);
            }
        } catch (JWTException $e) {
            return $this->handleResponse(null, "Failed to login, please try again.", 500);
        }
       $manager = auth('manager')->user();
        $data = [];
        $data['manager'] = $manager;
        $data['token'] = $token;
        return $this->handleResponse($data, "manager logged in successfully", 200);

    }
    public function logout()
    {
        auth('manager')->logout();
        return $this->handleResponse(null, "manager logged out successfully", 200);
    }
}
