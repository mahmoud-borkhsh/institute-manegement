<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthUserController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8']
        ]);
        if ($validator->fails())
            return $this->handleResponse(null, $validator->errors()->first(), 400);

        $credential_email = array(
            'email' => $request->username,
            'password' => $request->password
        );

        $credential_phone = array(
            'phone' => $request->username,
            'password' => $request->password
        );

        $logined = false;
        $token = '';
        try {

            if ($log1 = auth('teacher')->attempt($credential_email)) {
                $token = $log1;
                $logined = true;

            } elseif ($log2 = auth('teacher')->attempt($credential_phone)) {
                $token = $log2;
                $logined = true;
            }elseif ($log3 = auth('student')->attempt($credential_email)) {
                $token = $log2;
                $logined = true;
            }elseif ($log4 = auth('student')->attempt($credential_phone)) {
                $token = $log2;
                $logined = true;
            }
            if ($logined == false) {
                return $this->handleResponse(null, "wrong mobile or password", 400);
            }


        } catch (JWTException $e) {
            return $this->handleResponse(null, "Failed to login, please try again.", 500);
        }






        if($teacher = auth('teacher')->user()) {
            $data = [];
            $data['teacher'] = $teacher;
            $data['token'] = $token;
            return $this->handleResponse($data, "teacher logged in successfully", 200);
        } else {
            $teacher = auth('student')->user();
            $data = [];
            $data['student'] = $teacher;
            $data['token'] = $token;
            return $this->handleResponse($data, "student logged in successfully", 200);
        }
    }

    public function logout()
    {
        auth('teacher')->logout();
        return $this->handleResponse(null, "teacher logged out successfully", 200);
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => ['required'],
            'new_password' => ['required']
        ]);
        if ($validator->fails())
            return $this->handleResponse(null, $validator->errors()->first(), 400);

        $email = auth('teacher')->user()->email;
        $dataAtemp = [
            'email' => $email,
            'password' => $request->old_password,
        ];
        try {
            $token = auth('teacher')->attempt($dataAtemp);
            if (!$token) {
                return $this->handleResponse(null, "wrong mobile or password", 400);
            }
            $teacher = auth('teacher')->user();
            $teacher->password = $request->new_password;
            $teacher->save();
        } catch (JWTException $e) {
            return $this->handleResponse(null, "Failed to login, please try again.", 500);
        }
        return $this->handleResponse(null, "teacher reset password successfully", 200);
    }

    public function sendCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'exist:teacher,email'],
        ]);
        // sen code
        return $this->handleResponse(null, "teacher logged out successfully", 200);
    }

}
