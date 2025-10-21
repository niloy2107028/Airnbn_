<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * Auth Controller
 * Handles user authentication: signup, login, logout
 */
class AuthController extends Controller
{
    /**
     * Show signup form
     */
    public function showSignupForm()
    {
        return view('auth.signup');
    }

    /**
     * Handle signup
     */
    public function signup(Request $request)
    {
        try {
            $request->validate([
                'user.username' => 'required|string|unique:users,username|max:255',
                'user.email' => 'required|email|unique:users,email|max:255',
                'user.password' => 'required|string|min:6',
                'user.role' => 'required|in:guest,host',
            ]);

            $user = User::create([
                'username' => $request->input('user.username'),
                'email' => $request->input('user.email'),
                'password' => Hash::make($request->input('user.password')),
                'role' => $request->input('user.role'),
            ]);

            // Auto-login after registration
            Auth::login($user);

            return redirect()->route('listings.index')
                ->with('success', 'Welcome to Airnbn');
        } catch (\Exception $e) {
            return redirect()->route('signup')
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Show login form
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle login
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Attempt to authenticate using username instead of email
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            // Handle redirect URL from session
            $redirectUrl = session('url.intended');

            // Special handling for DELETE method in redirect URL
            if ($redirectUrl && str_contains($redirectUrl, '_method=DELETE')) {
                // Extract listing ID and redirect to listing show page
                preg_match('/\/listings\/(\d+)/', $redirectUrl, $matches);
                if (!empty($matches[1])) {
                    return redirect()->route('listings.show', $matches[1])
                        ->with('success', 'Welcome back to Airnbn');
                }
            }

            // Default redirect
            return redirect()->intended(route('listings.index'))
                ->with('success', 'Welcome back to Airnbn');
        }

        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ])->with('error', 'Invalid username or password');
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('listings.index')
            ->with('success', 'You are logged out!');
    }
}
