<?php

namespace App\Http\Middleware;

use App\Traits\GeneralTrait;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class CheckAdminToken
{
    use  GeneralTrait;

    public function handle(Request $request, Closure $next): Response
    {
        $user = null;
        try {

            $user = JWTAuth::parseToken()->authenticate();
        } catch (\Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return $this->returnError('E3001' , 'Token is Invalid');
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return $this->returnError('E3001' , 'Token is Expired');
            } else {
                return $this->returnError('E3001' , 'Authorization Token not found');
            }
        }
        if(!$user)
            return $this->returnError('', 'Unauthenticated');
        return $next($request);
    }
}
