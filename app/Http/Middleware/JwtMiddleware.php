<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        try {
            $payload = JWTAuth::parseToken()->getPayload();
            // Log payload or print to check if it's correctly retrieved
            \Log::info('Payload:', $payload->toArray());
        
            $user = JWTAuth::parseToken()->authenticate();
            // Log or print user to check if authentication was successful
            \Log::info('Authenticated User:', $user ? $user->toArray() : 'null');
        
            dd(Auth::user());
        } catch (\Exception $e) {
            dd($e->getMessage());

            if ($e instanceof TokenInvalidException) {
                return response()->json(['massage' => 'Token is Invalid'], 401);
            } else if ($e instanceof TokenExpiredException) {
                return response()->json(['massage' => 'Token is Expired'], 401);
            } else if ($e instanceof JWTException) {
                return response()->json(['massage' => 'Token not found'], 404);
            } else {
                return response()->json(['massage' => 'Anthor Exception'], 401);
            }
        }
        return $next($request);
    }
}
