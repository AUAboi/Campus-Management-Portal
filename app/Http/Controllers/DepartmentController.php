<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Department;
use App\Models\Faculty;
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
        $search = $request->search;
        $departments = Department::where('department_name', 'LIKE', '%' . $search . "%")->with('faculty')->orderBy('department_name')->paginate(10)->withQueryString();


        //To get result by faculty

        // $departments = Department::with('faculty')->whereHas('faculty', function ($q) use ($search) {
        //     $q->where('faculty_name', 'like', '%' . $search . '%');
        // })->orderBy('department_name')->paginate(10)->withQueryString();

        return Inertia::render("Admin/Departments/Index", ['departments' => $departments, 'filters' => $filters]);
    }

    public function create()
    {
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
        ]);
    }

    public function store(Request $request)
    {
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
        $request->validate([
            'department_name' => 'required|unique:departments,department_name,' . $department->id,
            'faculty_id' => 'required|exists:faculties,id'
        ]);


        $department->update($request->only('department_name', 'faculty_id'));
        return Redirect::route('admin.departments')->with('success', 'Department updated.');
    }

    public function destroy(Department $department)
    {
        $department->delete();
        return Redirect::route('admin.departments')->with('success', 'Department deleted.');
    }
}
