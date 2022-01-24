<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\User;
use App\Services\UserImageService;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Event;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Comment::whereNotNull('id')->delete();
        User::whereNotNull('id')->delete();

        $adminUser = User::factory(['email' => 'admin@admin.lt'])->create();

        Event::fake();

        $users = User::factory()->count(3)->create();
        $users->add($adminUser);

        Comment::factory(['user_id' => User::first()->id])->count(3)->create();

        Comment::factory()
            ->count(10)
            ->state(new Sequence(
                fn($sequence) => [
                    'user_id' => User::pluck('id')->random(),
                    'parent_id' => Comment::pluck('id')->random(),
                ],
            ))
            ->create();

        Comment::factory()
            ->state(new Sequence(
                fn($sequence) => [
                    'user_id' => User::pluck('id')->random(),
                    'parent_id' => collect(Comment::pluck('id'), null)->random(),
                ],
            ))
            ->count(20)
            ->create();

        /** @var UserImageService $imageService */
        $imageService = resolve(UserImageService::class);

        foreach ($users as $user) {
            $imageService->getRandomUserImage($user);
        }
    }
}
