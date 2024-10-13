<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LoginController extends Controller
{
    public function login()
    {
        return Inertia::render('Login', []);
    }

    public function authenticate(LoginRequest $request)
    {
        // $validated = $request->validate([
        //     'username' => ['required', 'string'],
        //     'password' => ['required', 'string'],
        // ]);

        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended('/');
    }

    public function daftar()
    {
        return Inertia::render('Registrasi', []);
    }

    public function registrasi(Request $request) {}
}
