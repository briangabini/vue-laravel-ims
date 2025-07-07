<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\SecurityQuestion;
use App\Models\UserSecurityAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class SecurityQuestionController extends Controller
{
    public function edit()
    {
        $user = Auth::user()->load('userSecurityAnswers');
        $allSecurityQuestions = SecurityQuestion::all();
        $userSecurityAnswers = collect($user->userSecurityAnswers)->map(function ($answer) {
            return [
                'security_question_id' => $answer->security_question_id,
                'answer' => '', // Do not send the actual answer to the frontend
            ];
        });

        \Log::info('Data passed to SecurityQuestions.vue:', [
            'allSecurityQuestions' => $allSecurityQuestions->toArray(),
            'userSecurityAnswers' => $userSecurityAnswers->toArray(),
        ]);

        return Inertia::render('settings/SecurityQuestions', [
            'allSecurityQuestions' => $allSecurityQuestions,
            'userSecurityAnswers' => $userSecurityAnswers,
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $selectedQuestions = $request->input('selectedQuestions');

        $request->validate([
            'selectedQuestions' => 'array',
            'selectedQuestions.*.security_question_id' => 'required|exists:security_questions,id',
            'selectedQuestions.*.answer' => 'required|string|max:255',
        ]);

        // Delete existing answers not in the new selection
        $selectedQuestionIds = collect($selectedQuestions)->pluck('security_question_id')->toArray();
        $user->securityAnswers()->whereNotIn('security_question_id', $selectedQuestionIds)->delete();

        foreach ($selectedQuestions as $q) {
            UserSecurityAnswer::updateOrCreate(
                ['user_id' => $user->id, 'security_question_id' => $q['security_question_id']],
                ['answer' => $q['answer']]
            );
        }

        return back()->with('success', 'Security questions updated successfully.');
    }
}
