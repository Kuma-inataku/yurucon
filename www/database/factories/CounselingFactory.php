<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Counseling>
 */
class CounselingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'counselor_id' => random_int(1, 3),
            'client_id' => random_int(1, 3),
            'content' => Str::random(30),
            // todo: enum 使う
            'status' => 1,
            'counseling_at' => now(), 
            'counseling_url' => Str::random(30).".com", 
            'schedule_url' => Str::random(40).".com", 
        ];
    }
}
