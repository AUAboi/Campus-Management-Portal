<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Faculty;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class AdminController extends Controller
{
    public function create()
    {
        return Inertia::render('Admin/Users/Admins/Create');
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
            'gender' => 'required|string'
        ]);



        $user = User::create([
            'name' => $request->name,
            'father_name' => $request->father_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'cnic' => $request->cnic,
            'phone' => $request->phone,
            'gender' => $request->gender
        ]);

        $user->assignRole('admin');
        $user->admin()->create();

        return redirect()->route('admin.users')->with('success', 'Admin created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return Inertia::render("Admin/Users/Admins/Edit", [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'roles' => $user->roles->pluck('name'),
                'faculties' => Faculty::select('id', 'faculty_name')->get()->transform(fn ($faculty) => [
                    'id' => $faculty->id,
                    'faculty_name' => $faculty->faculty_name,
                    'owns_faculty' => $user->admin->faculties->contains($faculty->id),
                ]),
                'permissions' => [
                    'create_faculties' => $user->can('create_faculties'),
                    'update_faculties' => $user->can('update_faculties'),
                    'delete_faculties' => $user->can('delete_faculties'),
                    'create_users' => $user->can('create_users'),
                    'update_users' => $user->can('update_users'),
                    'delete_users' => $user->can('delete_users'),
                ],
            ],
            'permissions' => [
                'delete' => auth()->user()->can('delete', $user),
            ]

        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $request->validate([
            'name' => 'required|string|max:255',
            'faculties' => 'array',
        ]);

        //Grab all permissions from the request and store in $permissions
        $selected_permissions = $request->only('permissions');

        $permissions = array_keys(array_filter($selected_permissions['permissions']));

        //delete all permissions from the user and set the new permissions
        $user->syncPermissions($permissions);

        //Grab all faculties for admin from the request and store in admin_faculties
        $faculties =  $request->only('faculties');

        $faculties = $faculties['faculties'];

        $faculties_id = array_filter($faculties, function ($faculty) {
            return $faculty['owns_faculty'] == true;
        });

        $faculties_id = array_map(function ($faculty) {
            return $faculty['id'];
        }, $faculties_id);


        $user->admin->faculties()->sync($faculties_id);


        $user->update($request->only('name'));

        return Redirect::route('admin.users')->with('success', 'User updated.');
    }
}
