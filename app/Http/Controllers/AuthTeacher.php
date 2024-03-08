<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthTeacher extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mobile' => ['required','exist:teacher'],
            'password' => ['required']
        ]);
        if ($validator->fails())
            return $this->handleResponse(null, $validator->errors()->first(), 400);

        try {
            $token = auth('teacher')->attempt($request->only('mobile', 'password'));
            if (!$token) {
                return $this->handleResponse(null, "wrong mobile or password", 400);
            }
        } catch (JWTException $e) {
            return $this->handleResponse(null, "Failed to login, please try again.", 500);
        }
        $teacher = auth('teacher')->user();
        $data = [];
        $data['teacher'] = $teacher;
        $data['token'] = $token;
        return $this->handleResponse($data, "teacher logged in successfully", 200);

    }
    public function logout()
    {
        auth('teacher')->logout();
        return $this->handleResponse(null, "teacher logged out successfully", 200);
    }

}
