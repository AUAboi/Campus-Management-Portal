<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Faculty;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->all('search');

        $departments =
            auth()->user()->hasRole('super-admin') ?
            Department::orderBy('department_name') :
            auth()->user()->admin->departments()->orderBy('department_name');

        $departments =
            $departments->filter($request->only('search'))
            ->with(['faculty'])
            ->paginate(10)
            ->withQueryString()
            ->through(fn ($department) => [
                'id' => $department->id,
                'department_name' => $department->department_name,
                'slug' => $department->slug,
                'faculty_name' => $department->faculty->faculty_name,
            ]);


        return Inertia::render(
            "Admin/Departments/Index",
            [
                'departments' => $departments,
                'filters' => $filters,
                'permissions' => [
                    'create' => auth()->user()->can('create', Faculty::class),
                ]
            ]
        );
    }

    public function create()
    {
        $this->authorize('create', Faculty::class);

        $faculties = Faculty::select('faculty_name', 'id')->get();
        return Inertia::render("Admin/Departments/Create", [
            'faculties' => $faculties,
            'permissions' => [
                'create' => auth()->user()->can('create', Department::class),
            ]
        ]);
    }

    public function edit(Department $department)
    {
        $this->authorize('view', $department);

        return Inertia::render("Admin/Departments/Edit", [
            'department' => [
                'id' => $department->id,
                'department_name' => $department->department_name,
                'slug' => $department->slug,
                'faculty_name' => $department->faculty->faculty_name,
                'faculty_id' => $department->faculty->id,
            ],


            'faculties' => Faculty::select('faculty_name', 'id')->get(),
            'permissions' => [
                'update' => auth()->user()->can('update', $department),
                'delete' => auth()->user()->can('delete', $department),
            ],
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('create', Faculty::class);

        $request->validate([
            'department_name' => 'required|unique:departments,department_name',
            'faculty_id' => 'required|exists:faculties,id'
        ]);

        $faculty = Faculty::find($request->faculty_id);

        $faculty->departments()->create([
            'department_name' => $request->department_name,
        ]);


        return Redirect::route('admin.departments')->with('success', 'Department created.');
    }

    public function update(Request $request, Department $department)
    {
        $this->authorize('update', $department);

        $request->validate([
            'department_name' => 'required|unique:departments,department_name,' . $department->id,
            'faculty_id' => 'required|exists:faculties,id'
        ]);


        $department->update([
            'department_name' => $request->department_name,
            'faculty_id' => $request->faculty_id,
        ]);
        return Redirect::route('admin.departments')->with('success', 'Department updated.');
    }

    public function destroy(Department $department)
    {
        $this->authorize('delete', $department);
        $department->delete();
        return Redirect::route('admin.departments')->with('success', 'Department deleted.');
    }
}
