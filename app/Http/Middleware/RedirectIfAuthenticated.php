<?php
// RedirectIfAuthenticated Middleware

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        // Check if the user is already authenticated
        if (Auth::check()) {
            $role = Auth::user()->role;
            
            // Redirect to appropriate dashboard based on user role
            if ($role === 'admin') {
                return redirect()->route('administrator')->withHeaders(['Cache-Control' => 'no-cache, no-store, must-revalidate']);
            } elseif ($role === 'user') {
                return redirect()->route('user')->withHeaders(['Cache-Control' => 'no-cache, no-store, must-revalidate']);
            }
        }

        return $next($request);
    }
}
