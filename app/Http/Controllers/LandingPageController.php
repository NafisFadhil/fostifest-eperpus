<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class LandingPageController extends Controller
{
    public function index()
    {
        return Inertia::render('Home', []);
    }

    public function book()
    {
        return Inertia::render('Book', []);
    }

    public function mybook()
    {
        return Inertia::render('MyBook', []);
    }

    public function checkout()
    {
        return Inertia::render('Checkout', []);
    }

    public function profil()
    {
        return Inertia::render('Profil', []);
    }
}
