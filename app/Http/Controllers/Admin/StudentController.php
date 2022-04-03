<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filters = $request->all('search');



        $students = Student::with('user')
            ->filter($request->only('search'))
            ->paginate(10)
            ->withQueryString()
            ->through(fn ($student) => [
                'id' => $student->id,
                'name' => $student->user->name,
                'email' => $student->user->email,
                'program' => $student->program->full_program_name,
            ]);



        return Inertia::render("Admin/Students/Index", [
            'students' => $students,
            'filters' => $filters,

        ]);
    }

    public function create()
    {
        return "Hello";
    }
}
