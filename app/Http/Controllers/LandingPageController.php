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

    // public function search(Request $request)
    // {
    //     return Inertia::render('Search', [
    //         'search' => $request->input('search')
    //     ]);
    // }
}
