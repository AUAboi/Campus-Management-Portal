<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Faculty;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Traits\UserStudentTrait;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    use UserStudentTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filters = $request->all('search', 'role');



        $users = User::with('roles')->orderBy('name')
            ->filter($request->only('search', 'role'))
            ->paginate(10)
            ->withQueryString()
            ->through(fn ($user) => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'avatar' => $user->avatar,
                'role' => $user->roles->pluck('name')->implode(', '),
            ]);


        return Inertia::render("Admin/Users/Index", [
            'users' => $users,
            'roles' => Role::select('name', 'id')->get(),
            'filters' => $filters,
            'permissions' => [
                'create' => auth()->user()->can('create', User::class),
            ]
        ]);
    }



    // public function store(Request $request)
    // {
    //     $this->authorize('create', User::class);
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'father_name' => 'required|string|max:255',
    //         'email' => 'required|string|email|max:255|unique:users',
    //         'password' => 'required|string|min:8',
    //         'cnic' => 'required|string|min:13|max:13|unique:users',
    //         'phone' => 'required|string|max:11',
    //         'role' => 'required|string|exists:roles,name',
    //     ]);


    //     $user = User::create([
    //         'name' => $request->name,
    //         'father_name' => $request->father_name,
    //         'email' => $request->email,
    //         'password' => Hash::make($request->password),
    //         'cnic' => $request->cnic,
    //         'phone' => $request->phone,
    //     ]);

    //     switch ($request->role) {
    //         case 'student':
    //             $this->createStudent($user, $request);
    //             break;
    //         case 'admin':
    //             $user->admin()->create();
    //             break;
    //         default:
    //             break;
    //     }


    //     $user->assignRole($request->role);


    //     return Redirect::route('admin.users')->with('success', 'User created successfully');
    // }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $user = User::with('student', 'admin', 'roles')->findOrFail($user->id);
        return Inertia::render("Admin/Users/Show", [
            'user' => $user,
            'permissions' => [
                'edit' => auth()->user()->can('update', $user),
                'delete' => auth()->user()->can('delete', $user),
            ],
        ]);
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

        if ($user->hasAnyRole(['student', 'teacher'])) {
            dd($user);
        }

        return Inertia::render("Admin/Users/Admin/Edit", [
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        $user->delete();

        return Redirect::route('admin.users')->with('success', 'User deleted.');
    }
}
