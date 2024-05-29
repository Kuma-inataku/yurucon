<?php

namespace Database\Factories;

use App\Enums\CounselingStatus;
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
            'status' => CounselingStatus::Requesting,
            'counseling_start_at' => now(),
            // TODO: add column
            // 'counseling_end_at' => now(),
            'counseling_term' => random_int(10, 15),
            'counseling_url' => Str::random(30) . ".com",
        ];
    }
}
