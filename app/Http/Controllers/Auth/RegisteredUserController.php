<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\SecurityQuestion;
use App\Models\User;
use App\Models\UserSecurityAnswer;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Show the registration page.
     */
    public function create(): Response
    {
        return Inertia::render('auth/Register', [
            'securityQuestions' => SecurityQuestion::all(),
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'security_questions' => 'required|array|min:1',
            'security_questions.*.security_question_id' => 'required|exists:security_questions,id',
            'security_questions.*.answer' => 'required|string|max:255',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        foreach ($request->security_questions as $question) {
            UserSecurityAnswer::create([
                'user_id' => $user->id,
                'security_question_id' => $question['security_question_id'],
                'answer' => $question['answer'],
            ]);
        }

        event(new Registered($user));

        Auth::login($user);

        return to_route('home');
    }
}
