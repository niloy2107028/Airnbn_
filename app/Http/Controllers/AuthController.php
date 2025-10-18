<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * Auth Controller
 * Ported from Node.js controllers/userController.js
 * Handles user authentication: signup, login, logout
 */
class AuthController extends Controller
{
    /**
     * Show signup form
     * Node.js: module.exports.renderSignUpForm
     */
    public function showSignupForm()
    {
        return view('auth.signup');
    }

    /**
     * Handle signup
     * Node.js: module.exports.signUpDb
     * Equivalent to passport-local-mongoose register() + req.login()
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

            // Node.js: const newUser = new userModel({ email, username });
            // Node.js: const registeredNewUser = await userModel.register(newUser, password);
            $user = User::create([
                'username' => $request->input('user.username'),
                'email' => $request->input('user.email'),
                'password' => Hash::make($request->input('user.password')),
                'role' => $request->input('user.role'),
            ]);

            // Auto-login after registration
            // Node.js: req.login(registeredNewUser, (err) => { ... })
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
     * Node.js: module.exports.loginForm
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle login
     * Node.js: module.exports.afterLoginCallbackFunction
     * Uses passport.authenticate middleware in Node.js, manual Auth::attempt() in Laravel
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
            // Node.js: let redirectUrl = res.locals.redirectUrl;
            $redirectUrl = session('url.intended');

            // Special handling for DELETE method in redirect URL
            // Node.js: if (redirectUrl && redirectUrl.includes("_method=DELETE"))
            if ($redirectUrl && str_contains($redirectUrl, '_method=DELETE')) {
                // Extract listing ID and redirect to listing show page
                // Node.js: const listingId = redirectUrl.split("/")[2];
                preg_match('/\/listings\/(\d+)/', $redirectUrl, $matches);
                if (!empty($matches[1])) {
                    return redirect()->route('listings.show', $matches[1])
                        ->with('success', 'Welcome back to Airnbn');
                }
            }

            // Default redirect
            // Node.js: res.redirect(redirectUrl || "/listings");
            return redirect()->intended(route('listings.index'))
                ->with('success', 'Welcome back to Airnbn');
        }

        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ])->with('error', 'Invalid username or password');
    }

    /**
     * Handle logout
     * Node.js: module.exports.logOut
     * Uses req.logout() in Node.js, Auth::logout() in Laravel
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
