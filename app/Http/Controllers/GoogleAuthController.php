<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    /**
     * Redirect to Google for authentication
     */
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google callback
     */
    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Check if user already exists
            $user = User::where('email', $googleUser->email)->first();

            if ($user) {
                // Update Google ID if not set
                if (!$user->google_id) {
                    $user->update([
                        'google_id' => $googleUser->id,
                    ]);
                }
            } else {
                // Split name into first and last name
                $nameParts = explode(' ', $googleUser->name, 2);
                $firstName = $nameParts[0];
                $lastName = isset($nameParts[1]) ? $nameParts[1] : '';

                // Create new user
                $user = User::create([
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'phone_number' => '', // Will be filled in step 1 if needed
                    'password' => Hash::make(Str::random(24)), // Random password
                    'email_verified_at' => now(),
                ]);
            }

            // Log in the user
            Auth::login($user);

            // If user doesn't have UMKM, redirect to step 2 of registration
            if (!$user->umkm) {
                session(['google_signup_step' => 2]);
                return redirect()->route('register')->with('message', 'Please complete your business information');
            }

            // Otherwise redirect to dashboard
            return redirect()->route('dashboard');
        } catch (\Exception $e) {
            return redirect()->route('register')->with('error', 'Unable to login with Google. Please try again.');
        }
    }
}
