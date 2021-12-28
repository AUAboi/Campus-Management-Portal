<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function create()
    {
        return Inertia::render('Admin/Users/Admin/Create');
    }

    public function store(UserRequest $request)
    {
        $request->validated();

        $user = User::create([
            'name' => $request->name,
            'father_name' => $request->father_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'cnic' => $request->cnic,
            'phone' => $request->phone,
        ]);

        $user->assignRole('admin');

        return redirect()->route('admin.users')->with('success', 'Admin created successfully');
    }
}
