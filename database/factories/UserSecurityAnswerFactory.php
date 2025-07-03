<?php

namespace Database\Factories;

use App\Models\SecurityQuestion;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserSecurityAnswer>
 */
class UserSecurityAnswerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'security_question_id' => SecurityQuestion::factory(),
            'answer_hash' => Hash::make(fake()->word()),
        ];
    }
}
