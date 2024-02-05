<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPassword
{

    public function handle(Request $request, Closure $next): Response
    {
            //this is password for api
        if ( $request->api_password !== env('API_PASSWORD', 'xIjTnlcBsAA0QGsGBS8RXuyk')) {
            return response()->json(['message' => 'unauthenticated.']);
        }

        return $next($request);
    }
}
