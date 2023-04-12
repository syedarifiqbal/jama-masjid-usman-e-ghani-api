<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtMiddleware extends BaseMiddleware
{
    public function handle($request, Closure $next)
    {
        try {
            // Check if a valid token is present in the request
            $token = JWTAuth::parseToken();
            if (!$token->authenticate()) {
                return response()->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
            }
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json(['error' => 'Token is invalid'], Response::HTTP_UNAUTHORIZED);
            } elseif ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json(['error' => 'Token is expired'], Response::HTTP_UNAUTHORIZED);
            } else {
                return response()->json(['error' => 'Token not found'], Response::HTTP_UNAUTHORIZED);
            }
        }

        return $next($request);
    }
}
