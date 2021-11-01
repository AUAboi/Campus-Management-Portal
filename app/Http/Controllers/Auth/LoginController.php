<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
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

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = "/home";

    /**
     * 
     * Redirects to dashboard of role
     * 
     */


    protected function redirectTo()
    {
        if (auth()->user()->hasRole('student')) {
            return '/student/dashboard';
        }
        return '/home';
    }


    protected function showLoginForm()
    {
        return Inertia::render("User/LoginPage");
    }

    /**
     * 
     * Overwriting loggedOut method
     * 
     * Redirects to login page
     * 
     */

    protected function loggedOut()
    {
        return Inertia::render("User/LoginPage");
    }

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
