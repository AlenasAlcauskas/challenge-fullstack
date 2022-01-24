<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\UserCreated;
use App\Services\UserImageService;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateUserPicture
{
    public function __construct(private UserImageService $userImageService)
    {
    }

    public function handle(UserCreated $event)
    {
        $this->userImageService->getRandomUserImage($event->user);
    }
}
