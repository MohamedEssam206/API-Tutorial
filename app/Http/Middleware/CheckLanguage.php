<?php

namespace App\Http\Middleware;

use App\Traits\GeneralTrait;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckLanguage

{
    use  GeneralTrait;

    public function handle(Request $request, Closure $next): Response
    {
        app()->setLocale('ar');

        if (isset($request -> Langauge) && $request -> Langauge == 'en' )
            app()->setLocale('en');

        return $next($request);
    }
}
