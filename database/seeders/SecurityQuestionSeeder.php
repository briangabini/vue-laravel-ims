<?php

namespace Database\Seeders;

use App\Models\SecurityQuestion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SecurityQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SecurityQuestion::create(['question_text' => 'What was the name of your first pet?']);
        SecurityQuestion::create(['question_text' => 'What is your mother\'s maiden name?']);
        SecurityQuestion::create(['question_text' => 'What was the name of the street you first lived on?']);
        SecurityQuestion::create(['question_text' => 'What is the name of your favorite childhood friend?']);
        SecurityQuestion::create(['question_text' => 'In what city were you born?']);
    }
}
