<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Inertia\Inertia;

class SecurityQuestionPasswordResetController extends Controller
{
    public function showEmailForm()
    {
        return Inertia::render('auth/ForgotPasswordSecurity');
    }

    public function showQuestions(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'No user found with this email address.']);
        }

        $securityQuestions = $user->userSecurityAnswers()->with('securityQuestion')->get();

        if ($securityQuestions->isEmpty()) {
            return back()->withErrors(['email' => 'This user has no security questions set up.']);
        }

        return Inertia::render('auth/VerifySecurityQuestion', [
            'email' => $user->email,
            'securityQuestions' => $securityQuestions->map(function ($answer) {
                return [
                    'id' => $answer->security_question_id,
                    'question_text' => $answer->securityQuestion->question_text,
                ];
            }),
        ]);
    }

    public function verifyAnswer(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'security_question_id' => 'required|exists:security_questions,id',
            'answer' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'No user found with this email address.']);
        }

        $userAnswer = $user->userSecurityAnswers()
            ->where('security_question_id', $request->security_question_id)
            ->first();

        if (!$userAnswer || !$userAnswer->verifyAnswer($request->answer)) {
            return back()->withErrors(['answer' => 'The answer to the security question is incorrect.']);
        }

        $token = Password::createToken($user);

        return redirect()->route('password.reset', ['token' => $token, 'email' => $user->email]);
    }
}
