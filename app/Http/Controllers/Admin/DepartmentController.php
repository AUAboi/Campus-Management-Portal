<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Department;
use App\Models\Faculty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use Spatie\Permission\Contracts\Permission;
use Spatie\Permission\Contracts\Role;

class DepartmentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function index(Request $request)
    {
        $filters = $request->all('search');

        $departments =  Department::orderBy('department_name')
            ->filter($request->only('search'))
            ->with('faculty')
            ->paginate(10)
            ->withQueryString();

        return Inertia::render("Admin/Departments/Index", ['departments' => $departments, 'filters' => $filters, 'permissions' => [
            'create' => auth()->user()->can('create', Faculty::class),
        ]]);
    }

    public function create()
    {
        $this->authorize('create', Faculty::class);
        $faculties = Faculty::select('faculty_name', 'id')->get();
        return Inertia::render("Admin/Departments/Create", [
            'faculties' => $faculties
        ]);
    }

    public function edit(Department $department)
    {
        return Inertia::render("Admin/Departments/Edit", [
            'department' => [
                'id' => $department->id,
                'department_name' => $department->department_name,
                'faculty_name' => $department->faculty->faculty_name,
                'faculty_id' => $department->faculty->id,
            ],
            'faculties' => Faculty::select('faculty_name', 'id')->get(),
            'permissions' => [
                //right now we only have one permission delete faculty to manage everything
                'delete' => auth()->user()->can('delete_faculties'),
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


        $faculty->departments()->create($request->only('department_name'));
        return Redirect::route('admin.departments')->with('success', 'Department created.');
    }

    public function update(Request $request, Department $department)
    {
        $this->authorize('update', $department);

        $request->validate([
            'department_name' => 'required|unique:departments,department_name,' . $department->id,
            'faculty_id' => 'required|exists:faculties,id'
        ]);


        $department->update($request->only('department_name', 'faculty_id'));
        return Redirect::route('admin.departments')->with('success', 'Department updated.');
    }

    public function destroy(Department $department)
    {
        $this->authorize('delete', $department);
        $department->delete();
        return Redirect::route('admin.departments')->with('success', 'Department deleted.');
    }
}
