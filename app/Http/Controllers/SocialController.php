<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    public function googleRedirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function loginWithGoogle()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $user = $this->findOrCreateUser($googleUser);

            Auth::login($user);

            return redirect('/home'); // Adjust the redirect URL as needed

            }catch (\Throwable $e) {
            return $e->getMessage();
            }
      }
     
    
private function findOrCreateUser($googleUser)
{
    $user = User::where('google_id', $googleUser->id)->first();

    if ($user) {
        return $user;
    }

    return User::create([
        'name' => $googleUser->name,
        'email' => $googleUser->email,
        'google_id' => $googleUser->id,
    ]);
}
        
}

