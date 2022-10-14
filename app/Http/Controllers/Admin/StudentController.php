<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Program;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Traits\UserStudentTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserStudentRequest;
use App\Services\Admin\StudentService;
use Exception;

class StudentController extends Controller
{

    public function create()
    {
        $this->authorize('create', User::class);

        $programs = Program::with(['department', 'degree'])->get();

        return Inertia::render('Admin/Users/Students/Create', [
            'programs' => $programs->map(fn ($program) => [
                'id' => $program->id,
                'program_name' => $program->full_program_name
            ])
        ]);
    }

    public function store(StoreUserStudentRequest $request, StudentService $studentService)
    {
        $this->authorize('create', User::class);

        $studentService->createUserStudent($request->validated());


        return redirect()->route('admin.users')->with('success', 'Student created successfully');
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);

        return Inertia::render('Admin/Users/Students/Edit', [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'father_name' => $user->father_name,
                'email' => $user->email,
                'cnic' => $user->cnic,
                'phone' => $user->phone,
                'student' => $user->student,
            ],

            'permissions' => [
                'delete' => auth()->user()->can('delete', $user),
                'update' => auth()->user()->can('update', $user),
            ],
        ]);
    }

    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);
        //add student info validation

        $user->update($request->validated());

        return redirect()->route('admin.users')->with('success', 'Student updated successfully');
    }

    public function show(User $user)
    {
        return Inertia::render("Admin/Users/Students/Show", [
            'user' => $user->load('student'),
            'permissions' =>  [
                'edit' => auth()->user()->can('update', $user),
                'delete' => auth()->user()->can('delete', $user),
            ],
        ]);
    }
}
