<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class LoginAttemptController extends Controller
{
    public function index(): Response
    {
        $loginAttempts = Auth::user()->loginAttempts()->orderByDesc('logged_in_at')->paginate(10);

        return Inertia::render('customers/LoginAttempts', [
            'loginAttempts' => $loginAttempts,
        ]);
    }
}
