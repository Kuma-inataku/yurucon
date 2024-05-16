<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Counselor>
 */
class CounselorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'user_id' => random_int(1, 3),
            'profile_image' => "/storage/sample/prof_image/" . Str::random(10) . '.png',
            'profile' => Str::random(10),
        ];
    }
}
