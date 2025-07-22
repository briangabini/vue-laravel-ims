<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function index(): Response
    {
        if (auth()->user()->role->name === 'admin' || auth()->user()->role->name === 'manager') {
            return Inertia::render('admin/Home');
        } else if (auth()->user()->role->name === 'customer') {
            return Inertia::render('customers/CustomerDashboard');
        }
        // Fallback for any other roles or if role is not set
        return Inertia::render('Welcome');
    }
}
