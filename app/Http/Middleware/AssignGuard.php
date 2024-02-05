<?php

namespace App\Http\Middleware;

use App\Traits\GeneralTrait;
use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;


class AssignGuard extends BaseMiddleware
{
    use GeneralTrait;

    public function handle(Request $request, Closure $next , $guard = null)
    {
        // الامر ده كل الي بيهمله انه بيباصي guard ايا كان اسم الجارد بس ال guard ده بيكون null
        if ($guard !=null)
            auth()->shouldUse($guard); // Should use User Guard / Table
            $token = $request->header('auth-token');
            $request->headers->set('auth-token' , (string) $token , true);
            $request->headers->set('Authorization' , 'Bearer'.$token , true);
        try {
            //$user = $this->auth->authenticate($request);    // Check Authenticated User
            $user = JWTAuth::parseToken()->authenticate();
        }catch (TokenExpiredException $e){
            return $this-> returnError('401' , 'Unauthenticated user');
        }catch (JWTException $e){
            return $this->returnError('E3001' , 'Token Invalid '. $e->getMessage());
        }
        return $next($request);
    }
}
