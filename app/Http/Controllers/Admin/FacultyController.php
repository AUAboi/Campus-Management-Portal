<?php

namespace App\Http\Controllers\Admin;

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
        $this->middleware('can:create faculties')->only(['create', 'store']);
        $this->middleware('can:update,faculty')->only(['edit', 'update']);
        $this->middleware('can:delete,faculty')->only(['destroy']);
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
            'create' => $user->can('create faculties'),
        ]]);
    }

    public function create()
    {
        return Inertia::render("Admin/Faculties/Create");
    }

    public function edit(Faculty $faculty)
    {

        return Inertia::render("Admin/Faculties/Edit", [
            'faculty' => [
                'id' => $faculty->id,
                'faculty_name' => $faculty->faculty_name,
                'departments' => $faculty->departments()->orderBy('department_name')->get()->map->only('id', 'department_name'),
            ],
            'permissions' => [
                'delete' => auth()->user()->can('delete', 'faculty'),
            ],
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'faculty_name' => 'required|unique:faculties,faculty_name',
        ]);

        Faculty::create($request->only('faculty_name'));
        return Redirect::route('admin.faculties')->with('success', 'Faculty created.');
    }

    public function update(Request $request, Faculty $faculty)
    {
        $request->validate([
            'faculty_name' => 'required|unique:faculties,faculty_name,' . $faculty->id,
        ]);

        $faculty->update($request->only('faculty_name'));
        return Redirect::route('admin.faculties')->with('success', 'Faculty updated.');
    }

    public function destroy(Faculty $faculty)
    {
        $faculty->delete();
        return Redirect::route('admin.faculties')->with('success', 'Faculty deleted.');
    }
}
