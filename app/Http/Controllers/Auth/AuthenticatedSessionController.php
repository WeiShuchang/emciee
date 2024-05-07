<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\Redirect;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Check user's role and redirect accordingly
        $user = $request->user();
        if ($user->role === 'admin') {
            return Redirect::intended(route('administrator'))->withHeaders(['Cache-Control' => 'no-cache, no-store, must-revalidate'])
                ->with('success', 'Login successful!');
        } elseif ($user->role === 'user') {
            return Redirect::intended(route('user'))->withHeaders(['Cache-Control' => 'no-cache, no-store, must-revalidate'])
                ->with('success', 'Login successful!');
        }

        // If the user's role is not defined, redirect to default dashboard
        return redirect()->intended(route('/', absolute: false))->with('success', 'Login successful!');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('login')->with('success', 'Logout successful!');
    }
}