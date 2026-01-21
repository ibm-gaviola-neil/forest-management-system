<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Socialite;

class GoogleCallbackController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

     /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            // Check if user already exists
            $existingUser = User::where('email', $googleUser->email)->first();
            
            if ($existingUser) {
                // Update the Google ID if it doesn't exist
                if (empty($existingUser->google_id)) {
                    $existingUser->google_id = $googleUser->id;
                    $existingUser->save();
                }
                
                Auth::login($existingUser);
            } else {
                // Create new user
                $newUser = User::create([
                    'last_name' => $googleUser->user['family_name'],
                    'first_name' => $googleUser->user['given_name'],
                    'email' => $googleUser->user['email'],
                    'username' => $googleUser->user['email'],
                    'role' => 'applicant',
                    'google_id' => $googleUser->user['id'],
                    'password' => Hash::make(Str::random(16)),
                    'email_verified_at' => now(),
                ]);
                
                Auth::login($newUser);
            }
            
            return redirect()->intended('/applicant/dashboard'); // Redirect to dashboard or home
            
        } catch (Exception $e) {
            return redirect('/')->with('error', 'Google authentication failed');
        }
    }
}
