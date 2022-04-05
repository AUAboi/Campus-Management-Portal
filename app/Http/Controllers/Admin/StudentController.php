<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StudentController extends Controller
{
    public function create()
    {
        return Inertia::render('Admin/Users/Students/Create');
    }



    public function edit(User $user)
    {
        $this->authorize('update', $user);

        return Inertia::render('Admin/Users/Students/Edit', [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'father_name' => $user->father_name,
                'email' => $user->email,
                'cnic' => $user->cnic,
                'phone' => $user->phone,
                'student' => $user->student,
            ],

            'permissions' => [
                'delete' => auth()->user()->can('delete', $user),
                'update' => auth()->user()->can('update', $user),
            ],
        ]);
    }

    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $request->validate([
            'name' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'cnic' => 'required|string|min:13|max:13|unique:users,cnic,' . $user->id,
            'phone' => 'required|string|max:11',
            //add student info validation
        ]);

        $user->update([
            'name' => $request->name,
            'father_name' => $request->father_name,
            'email' => $request->email,
            'cnic' => $request->cnic,
            'phone' => $request->phone,
        ]);

        return redirect()->route('admin.users')->with('success', 'Student updated successfully');
    }
}
