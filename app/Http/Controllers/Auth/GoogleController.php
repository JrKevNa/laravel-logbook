<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;

class GoogleController extends Controller
{
    //
    // Step 1: Redirect to Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Step 2: Handle Google callback
    public function handleGoogleCallback()
    {
        // Get user info from Google
        $googleUser = Socialite::driver('google')->stateless()->user();

        // Check if the user exists
        $user = User::where('email', $googleUser->getEmail())->first();

        if (!$user) {
            // User not found, redirect back with error
            return redirect()->route('login')->withErrors([
                'google_login' => 'No account found for this Google email. Please register first.',
            ]);
        }

        // Log the user in
        Auth::login($user, true);

        // Redirect to dashboard or intended page
        return redirect()->intended('/dashboard');
    }
}
