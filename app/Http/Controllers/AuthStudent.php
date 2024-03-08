<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthStudent extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => ['required','exist:student'],
            'password' => ['required']
        ]);
        if ($validator->fails())
            return $this->handleResponse(null, $validator->errors()->first(), 400);

        try {
            $token = auth('student')->attempt($request->only('mobile', 'password'));
            if (!$token) {
                return $this->handleResponse(null, "wrong mobile or password", 400);
            }
        } catch (JWTException $e) {
            return $this->handleResponse(null, "Failed to login, please try again.", 500);
        }
        $student = auth('student')->user();
        $data = [];
        $data['student'] = $student;
        $data['token'] = $token;
        return $this->handleResponse($data, "student logged in successfully", 200);

    }
    public function logout()
    {
        auth('student')->logout();
        return $this->handleResponse(null, "student logged out successfully", 200);
    }

}
