<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class MasukController extends Controller
{

    public function login()
    {
        return Inertia::render('Login', []);
    }

    public function daftar()
    {
        return Inertia::render('Registrasi', []);
    }

    public function registrasi(Request $request)
    {
        // return Inertia::render('Registrasi', []);
    }
}
