<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * Auth Controller
 * user registration, login, logout handle kore
 */
class AuthController extends Controller
{
    /**
     * signup form dekhabo
     */
    public function showSignupForm()
    {
        return view('auth.signup');
    }

    /**
     * signup handle korbo
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

            // registration er por auto login kore dibo
            Auth::login($user);

            return redirect()->route('listings.index')
                ->with('success', 'Welcome to Airnbn');
        } catch (\Exception $e) {
            return redirect()->route('signup')
                ->with('error', $e->getMessage());
        }
    }

    /**
     * login form dekhabo
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * login handle korbo
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // username diye login attempt korbo
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            // session theke redirect URL ta nibo
            $redirectUrl = session('url.intended');

            // DELETE method thakle special handling
            if ($redirectUrl && str_contains($redirectUrl, '_method=DELETE')) {
                // listing ID ber kore listing page e pathabo
                preg_match('/\/listings\/(\d+)/', $redirectUrl, $matches);
                if (!empty($matches[1])) {
                    return redirect()->route('listings.show', $matches[1])
                        ->with('success', 'Welcome back to Airnbn');
                }
            }

            // na hole normal redirect
            return redirect()->intended(route('listings.index'))
                ->with('success', 'Welcome back to Airnbn');
        }

        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ])->with('error', 'Invalid username or password');
    }

    /**
     * logout handle korbo
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
