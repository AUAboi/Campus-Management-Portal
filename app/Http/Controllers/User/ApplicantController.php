<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;

class ApplicantController extends Controller
{
    public function registerView()
    {
        return Inertia::render("User/Applicant/Register");
    }

    public function register(StoreUserRequest $request)
    {
        $validated = $request->validated();
        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);
        $user->assignRole('applicant');

        if (Auth::attempt(['email' => $user['email'], 'password' => $user['password']])) {
            redirect()->route('applicant.dashboard');
        }
    }

    public function dashboard()
    {
        return Inertia::render("User/Applicant/Dashboard");
    }
}
