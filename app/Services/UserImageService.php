<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;

class UserImageService
{
    public function getRandomUserImage(User $user)
    {
        $client = new Client(['base_uri' => 'https://thispersondoesnotexist.com/']);

        $fileName = md5($user->email . microtime());

        try {
            $response = $client->request('GET', 'image', [
                'sink' => storage_path('app/public/pictures/' . $fileName . '.jpeg')
            ]);

            $user->picture = $fileName . '.jpeg';
            $user->save();
        } catch (GuzzleException $e) {
            Log::error($e->getMessage());
        }
    }
}
