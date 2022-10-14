<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Degree;
use App\Models\Faculty;
use App\Models\Program;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProgramRequest;
use App\Http\Requests\UpdateProgramRequest;

class ProgramController extends Controller
{
  public function index(Request $request)
  {
    $filters = $request->all('search', 'degree');

    $programs =  Program::orderBy('slug')
      ->filter($request->only('search', 'degree'))
      ->with(['department', 'degree'])
      ->paginate(10)
      ->withQueryString()
      ->through(fn ($program) => [
        'id' => $program->id,
        'program_name' => $program->full_program_name,
        'slug' => $program->slug,
        'department_name' => $program->department->department_name,
        'credit_hours' => $program->credit_hours,
      ]);

    return Inertia::render("Admin/Programs/Index", [
      'programs' => $programs,
      'degrees' => Degree::select('id', 'degree_name')->get(),
      'filters' => $filters,
      'permissions' => [
        'create' => auth()->user()->can('create', Program::class),
      ]
    ]);
  }


  public function create()
  {
    $this->authorize('create', Program::class);
    $departments = Department::select('department_name', 'id')->get();
    $degrees = Degree::select('degree_name', 'id')->get();

    return Inertia::render("Admin/Programs/Create", [
      'departments' => $departments,
      'degrees' => $degrees
    ]);
  }


  public function store(StoreProgramRequest $request)
  {
    $this->authorize('create', Faculty::class);

    if (Program::where('department_id', $request->department_id)->where('degree_id', $request->degree_id)->exists()) {
      return redirect()->back()->with('error', 'Program already exists');
    }

    Program::create($request->validated());

    return redirect()->route('admin.programs')->with('success', 'Program created successfully.');
  }

  public function edit(Program $program)
  {
    $this->authorize('update', $program);


    return Inertia::render("Admin/Programs/Edit", [
      'program' => [
        'id' => $program->id,
        'program_name' => $program->full_program_name,
        'degree_id' => $program->degree->id,
        'degree_name' => $program->degree->degree_name,
        'semesters' => $program->degree->semesters,
        'department_name' => $program->department->department_name,
        'department_id' => $program->department->id,
        'department_slug' => $program->department->slug,
        'credit_hours' => $program->credit_hours,
        'slug' => $program->slug

      ],

      'courses' => $program->courses()->orderBy('semester')->get()->transform(fn ($course) => [
        'id' => $course->id,
        'course_name' => $course->course_name,
        'course_code' => $course->course_code,
        'department_code' => $course->department_code,
        'credit_hours' => $course->credit_hours,
        'semester' => $course->pivot->semester,
      ]),

      'departments' => Department::select('department_name', 'id')->get(),
      'degrees' => Degree::select('degree_name', 'id')->get(),
      'permissions' => [
        'delete' => auth()->user()->can('delete', Program::class),
      ],
    ]);
  }

  public function update(UpdateProgramRequest $request, Program $program)
  {
    $this->authorize('update', $program);

    $program->update($request->validate());

    return redirect()->route('admin.programs')->with('success', 'Program updated successfully.');
  }

  public function destroy(Program $program)
  {
    $this->authorize('delete', $program);

    $program->delete();

    return redirect()->route('admin.programs')->with('success', 'Program deleted successfully.');
  }
}
