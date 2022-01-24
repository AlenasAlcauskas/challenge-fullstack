<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\JsonResponse;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

class SocialAuthController extends Controller
{

    public function redirectToProvider(): RedirectResponse
    {
        return Socialite::driver('google')->stateless()
            ->redirect();
    }

    public function handleProviderCallback(): RedirectResponse|JsonResponse
    {
        try {
            $user = Socialite::driver('google')->stateless()->user();
        } catch (ClientException $exception) {
            return response()->json(['error' => 'Invalid credentials provided.'], 422);
        }

        $userCreated = User::firstOrCreate(
            [
                'email' => $user->getEmail()
            ],
            [
                'email_verified_at' => now(),
                'name' => $user->getName(),
                'status' => true,
            ]
        );

        $userCreated->provider()->updateOrCreate(
            [
                'provider' => 'google',
                'provider_id' => $user->getId(),
            ],
            [
                'avatar' => $user->getAvatar()
            ]
        );

        Auth::login($userCreated);

        return(redirect('/comments?social=true'));
    }
}
