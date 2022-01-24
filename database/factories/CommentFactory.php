<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition(): array
    {
        return [
            'parent_id' => null,
            'user_id' => User::first()->id,
            'comment' => $this->faker->sentence(),
        ];
    }
}
