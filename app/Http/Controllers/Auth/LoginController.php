<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
            'g-recaptcha-response' => 'required'
        ], [
            'g-recaptcha-response.required' => 'Please complete the captcha'
        ]);
    }

    // protected function sendFailedLoginResponse(Request $request)
    // {
    // 	throw ValidationException::withMessages([
    // 		$this->username() => "Invalid username or password",
    // 		'g-recaptcha-response.required' => 'Please complete the captcha'
    // 	]);
    // }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('guest')->except('logout');
        // $this->middleware('auth')->only('logout');
    }

    public function login()
    {
        return Inertia::render('Login', []);
    }

    public function authenticate()
    {
        (new AuthenticatedSessionController())->store(request());
    }
}
