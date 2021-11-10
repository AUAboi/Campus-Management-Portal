<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Faculty;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Spatie\Permission\Models\Permission;

class FacultyController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function index(Request $request)
    {

        $user = auth()->user();

        $filters = $request->all('search');

        if ($user->hasRole('super admin')) {
            $faculties = Faculty::orderBy('faculty_name')
                ->filter($request->only('search'))
                ->paginate(5)
                ->withQueryString();
        } else {
            $faculties = $user->admin->faculties()->orderBy('faculty_name')
                ->filter($request->only('search'))
                ->paginate(5)
                ->withQueryString();
        }

        return Inertia::render("Admin/Faculties/Index", ['faculties' => $faculties, 'filters' => $filters, 'permissions' => [
            'create' => $user->can('create', Faculty::class),
        ]]);
    }

    public function create()
    {
        $this->authorize('create', Faculty::class);
        return Inertia::render("Admin/Faculties/Create");
    }

    public function edit(User $user, Faculty $faculty)
    {
        $this->authorize('update', $user, Faculty::class);

        return Inertia::render("Admin/Faculties/Edit", [
            'faculty' => [
                'id' => $faculty->id,
                'faculty_name' => $faculty->faculty_name,
                'departments' => $faculty->departments()->orderBy('department_name')->get()->map->only('id', 'department_name'),
            ],
            'permissions' => [
                'delete' => auth()->user()->can('delete faculties'),
            ],
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('create', Faculty::class);

        $request->validate([
            'faculty_name' => 'required|unique:faculties,faculty_name',
        ]);

        Faculty::create($request->only('faculty_name'));
        return Redirect::route('admin.faculties')->with('success', 'Faculty created.');
    }

    public function update(Request $request, Faculty $faculty)
    {
        $this->authorize('update', Faculty::class);

        $request->validate([
            'faculty_name' => 'required|unique:faculties,faculty_name,' . $faculty->id,
        ]);

        $faculty->update($request->only('faculty_name'));
        return Redirect::route('admin.faculties')->with('success', 'Faculty updated.');
    }

    public function destroy(Faculty $faculty)
    {
        $this->authorize('delete', Faculty::class);

        $faculty->delete();
        return Redirect::route('admin.faculties')->with('success', 'Faculty deleted.');
    }
}
