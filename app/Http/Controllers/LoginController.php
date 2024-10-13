<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Str;

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

    public function registrasi(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required',
            'password' => 'required',
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
        ]);
        $role = Role::where('code', 'MEMBER')->first();

        $user = User::create([
            ...$validated,
            'id' => Uuid::uuid7(),
            'role_id' => $role->id,
        ]);

        return redirect('/masuk')->with(['status' => true, 'message' => 'Data peminjaman berhasil ditambahkan', 'data' => $user], 200);
    }
}
