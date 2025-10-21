<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SaveIntendedUrl
{
    /**
     * Handle an incoming request.
     * Saves the intended URL from session to view for redirect after login
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (session()->has('url.intended')) {
            $request->attributes->set('redirectUrl', session('url.intended'));
        }

        return $next($request);
    }
}
