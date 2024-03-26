<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class StudentAuthMiddleware
{
    public function handle($request, Closure $next)
    {
        try {
            JWTAuth::parseToken()->authenticate();
            if(!auth('student')->user()){
                return response([
                    'data' => null,
                    'message' => "Token is Invalid",
                    'status' => 401,
                ], 401);
            }
        } catch (\Exception $e) {
            if ($e instanceof TokenInvalidException)
                return response([
                    'data' => null,
                    'message' => "Token is Invalid",
                    'status' => 401,
                ], 401);
            else if ($e instanceof TokenExpiredException)
                return response([
                    'data' => null,
                    'message' => "Token is Expired",
                    'status' => 401,
                ], 401);
            else
                return response([
                    'data' => null,
                    'message' => "Authorization Token not found",
                    'status' => 401,
                ], 401);
        }
        return $next($request);
    }
}
