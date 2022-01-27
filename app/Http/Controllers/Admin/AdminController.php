<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function create()
    {
        return Inertia::render('Admin/Users/Admin/Create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'confirmed|required|string|min:8',
            'cnic' => 'required|string|min:13|max:13|unique:users',
            'phone' => 'required|string|max:11',
        ]);



        $user = User::create([
            'name' => $request->name,
            'father_name' => $request->father_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'cnic' => $request->cnic,
            'phone' => $request->phone,
        ]);

        $user->assignRole('admin');
        $user->admin->create();

        return redirect()->route('admin.users')->with('success', 'Admin created successfully');
    }
}
