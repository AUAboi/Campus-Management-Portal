<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Degree;
use App\Models\Faculty;
use App\Models\Program;
use App\Models\Student;
use App\Models\Department;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProgramController extends Controller
{
  public function index(Request $request)
  {
    $filters = $request->all('search');

    $programs =  Program::orderBy('id')
      ->filter($request->only('search'))
      ->with(['department', 'degree'])
      ->paginate(10)
      ->withQueryString();

    return Inertia::render("Admin/Programs/Index", ['programs' => $programs, 'filters' => $filters, 'permissions' => [
      'create' => auth()->user()->can('create', Faculty::class),
    ]]);
  }


  public function create()
  {
    $this->authorize('create', Faculty::class);

    $departments = Department::select('department_name', 'id')->get();
    $degrees = Degree::select('degree_name', 'id')->get();

    return Inertia::render("Admin/Programs/Create", [
      'departments' => $departments,
      'degrees' => $degrees
    ]);
  }


  public function store(Request $request)
  {
    $this->authorize('create', Faculty::class);

    $request->validate([
      'department_id' => 'required|integer|exists:departments,id',
      'degree_id' => 'required|integer|exists:degrees,id',
      'credit_hours' => 'required|integer|max:999',
    ]);

    if (Program::where('department_id', $request->department_id)->where('degree_id', $request->degree_id)->exists()) {
      return redirect()->back()->with('error', 'Program already exists');
    }

    $title = Degree::find($request->degree_id)->degree_name . Department::find($request->department_id)->department_name;

    Program::create([
      'department_id' => $request->department_id,
      'degree_id' => $request->degree_id,
      'credit_hours' => $request->credit_hours,
      'slug' => Str::slug($title)
    ]);

    return redirect()->route('admin.programs')->with('success', 'Program created successfully.');
  }

  public function edit(Program $program)
  {
    $this->authorize('update', $program);

    return Inertia::render("Admin/Programs/Edit", [
      'program' => [
        'id' => $program->id,
        'degree_id' => $program->degree->id,
        'degree_name' => $program->degree->degree_name,
        'department_name' => $program->department->department_name,
        'department_id' => $program->department->id,
        'credit_hours' => $program->credit_hours,
        'slug' => $program->slug
      ],
      'departments' => Department::select('department_name', 'id')->get(),
      'degrees' => Degree::select('degree_name', 'id')->get(),
      'permissions' => [
        'delete' => auth()->user()->can('delete_faculties'),
      ],
    ]);
  }

  public function update(Request $request, Program $program)
  {
    $this->authorize('update');


    $request->validate([
      'department_id' => 'required|integer|exists:departments,id',
      'degree_id' => 'required|integer|exists:degrees,id',
      'credit_hours' => 'required|integer|max:999',
    ]);

    if (Program::where('department_id', $request->department_id)->where('degree_id', $request->degree_id)->where('id', '!=', $program->id)->exists()) {
      return redirect()->back()->with('error', 'Program already exists');
    }

    $title = Degree::find($request->degree_id)->degree_name . Department::find($request->department_id)->department_name;

    $program->update([
      'department_id' => $request->department_id,
      'degree_id' => $request->degree_id,
      'credit_hours' => $request->credit_hours,
      'slug' => Str::slug($title)
    ]);

    return redirect()->route('admin.programs')->with('success', 'Program updated successfully.');
  }

  public function destroy(Program $program)
  {
    $this->authorize('delete', $program);

    $program->delete();

    return redirect()->route('admin.programs')->with('success', 'Program deleted successfully.');
  }
}
