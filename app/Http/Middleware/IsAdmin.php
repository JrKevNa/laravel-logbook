<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // must be logged in
        if (!auth()->check()) {
            abort(403, 'Not authenticated.');
        }

        // must be admin
        if (!auth()->user()->hasRole('admin')) {
            abort(403, 'Admins only.');
        }
        
        return $next($request);
    }
}
