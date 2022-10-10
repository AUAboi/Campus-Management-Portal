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

        $users = User::with(['roles'])->orderBy('name')
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
            'permissions' =>  [
                'edit' => auth()->user()->can('update', $user),
                'delete' => auth()->user()->can('delete', $user),
            ],
        ]);
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
