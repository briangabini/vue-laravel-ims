<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\SecurityQuestion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Inertia\Inertia;

class SecurityQuestionPasswordResetController extends Controller
{
    public function showLinkRequestForm()
    {
        return Inertia::render('auth/ForgotPasswordSecurity', [
            'securityQuestions' => SecurityQuestion::all(),
        ]);
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'security_question_id' => 'required|exists:security_questions,id',
            'answer' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => __('Invalid credentials.')]);
        }

        $userAnswer = $user->userSecurityAnswers()
            ->where('security_question_id', $request->security_question_id)
            ->first();

        if (!$userAnswer || !$userAnswer->verifyAnswer($request->answer)) {
            return back()->withErrors(['email' => __('Invalid credentials.')]);
        }

        $token = Password::createToken($user);

        return redirect()->route('password.reset', ['token' => $token, 'email' => $user->email]);
    }
}
