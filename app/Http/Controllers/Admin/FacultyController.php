<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Faculty;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class FacultyController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:admin']);
    }

    public function index(Request $request)
    {
        $filters = $request->all('search');
        $faculties = Faculty::where('faculty_name', 'LIKE', '%' . $request->search . "%")->orderBy('faculty_name')->paginate(5)->withQueryString();

        return Inertia::render("Admin/Faculties/Index", ['faculties' => $faculties, 'filters' => $filters]);
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
