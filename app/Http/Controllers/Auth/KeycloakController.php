<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class KeycloakController extends Controller
{
    public function redirectToProvider(): RedirectResponse
    {
        return Socialite::driver('keycloak')->redirect();
    }

    public function handleProviderCallback(): RedirectResponse
    {
        $user = Socialite::driver('keycloak')->user();

        $authUser = User::where('email',$user->email)->get()->first();

        Auth::login($authUser, true);

        return redirect()->intended(route('dashboard', absolute: false));
    }
}
