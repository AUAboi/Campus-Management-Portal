<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Faculty;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Program;
use App\Models\Student;
use Illuminate\Http\Request;

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

  public function edit(Program $program)
  {

    return Inertia::render("Admin/Programs/Edit", [
      'program' => [
        'id' => $program->id,
        'program_name' => $program->program_name,
        'department_name' => $program->department->department_name,
        'department_id' => $program->department->id,
      ],
      'departments' => Department::select('department_name', 'id')->get(),
      'permissions' => [
        'delete' => auth()->user()->can('delete_faculties'),
      ],
    ]);
  }
}
