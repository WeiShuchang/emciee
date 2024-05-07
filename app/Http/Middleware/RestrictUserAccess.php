<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RestrictUserAccess
{
    public function handle(Request $request, Closure $next)
    {
        // Check if the authenticated user has the "user" role
        if ($request->user() && $request->user()->role === 'user') {
            // If the user has the "user" role, deny access or redirect
            return redirect()->route('user')->with('error', 'Unauthorized action.');
        }

        // Allow access to the next middleware or controller method
        return $next($request);
    }
}
