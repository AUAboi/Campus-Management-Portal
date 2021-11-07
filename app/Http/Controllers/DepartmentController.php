<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class DepartmentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function index(Request $request)
    {
        $filters = $request->all('search');
        $departments = Department::where('department_name', 'LIKE', '%' . $request->search . "%")->orderBy('department_name')->paginate(10)->withQueryString();

        return Inertia::render("Admin/Departments/Index", ['departments' => $departments, 'filters' => $filters]);
    }

    public function create()
    {
        return Inertia::render("Admin/Departments/Create");
    }

    public function edit(Department $department)
    {
        return Inertia::render("Admin/Departments/Edit", [
            'department' => [
                'id' => $department->id,
                'department_name' => $department->department_name,
            ],
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'Department_name' => 'required|unique:Departments,Department_name',
        ]);

        Department::create($request->only('Department_name'));
        return Redirect::route('admin.Departments')->with('success', 'Department created.');
    }

    public function update(Request $request, Department $department)
    {
        $request->validate([
            'department_name' => 'required|unique:departments,department_name,' . $department->id,
        ]);

        $department->update($request->only('department_name'));
        return Redirect::route('admin.departments')->with('success', 'Department updated.');
    }

    public function destroy(Department $department)
    {
        $department->delete();
        return Redirect::route('admin.departments')->with('success', 'Department deleted.');
    }
}
