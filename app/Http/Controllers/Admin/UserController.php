<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use App\Models\Faculty;
use Illuminate\Support\Facades\Redirect;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filters = $request->all('search', 'role');


        $users = User::orderBy('name')
            ->filter($request->only('search', 'role'))->get()->transform(fn ($user) => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'avatar' => $user->avatar,
                'role' => $user->roles->pluck('name')->implode(', '),
            ]);


        return Inertia::render("Admin/Users/Index", ['users' => $users, 'filters' => $filters,  'permissions' => [
            'create' => auth()->user()->can('create', User::class),
        ]]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {

        return Inertia::render("Admin/Users/Show", [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'avatar' => $user->avatar,
                'role' => $user->roles->pluck('name')[0],
            ],
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

        return Inertia::render("Admin/Users/Edit", [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'roles' => $user->roles->pluck('name'),
            ],
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

        //Grab all permissions from the request and store in $permissions
        $selected_permissions = $request->only('permissions');
        $permissions = array_keys(array_filter($selected_permissions['permissions']));

        //delete all permissions from the user and set the new permissions
        $user->syncPermissions($permissions);

        //Grab all faculties for admin from the request and store in admin_faculties
        $faculties = $request->only('faculties');
        foreach ($faculties['faculties'] as $faculty) {

            if ($faculty['owns_faculty']) {
                $user->admin->faculties()->attach($faculty['id']);
            } else {
                $user->admin->faculties()->detach($faculty['id']);
            }
        }

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
