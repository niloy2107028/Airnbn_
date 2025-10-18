<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SaveIntendedUrl
{
    /**
     * Handle an incoming request.
     * Equivalent to Node.js saveRedirectUrl middleware
     * Saves the intended URL from session to view for redirect after login
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Node.js: if (req.session.redirectUrl) { res.locals.redirectUrl = req.session.redirectUrl; }
        if (session()->has('url.intended')) {
            $request->attributes->set('redirectUrl', session('url.intended'));
        }
        
        return $next($request);
    }
}
