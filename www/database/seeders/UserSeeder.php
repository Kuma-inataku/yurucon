<?php

namespace Database\Seeders;

use App\Enums\CurrentUserType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::factory(2)->create();

        // 検証用固定ユーザー
        \App\Models\User::factory()->create([
            'name' => 'Test',
            'email' => 'test@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'status' => CurrentUserType::Counselor,
        ]);
    }
}
