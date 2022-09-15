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
use Exception;

class StudentController extends Controller
{
    use UserStudentTrait;

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

    public function store(StoreUserStudentRequest $request)
    {
        $this->authorize('create', User::class);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'father_name' => $request->father_name,
                'cnic' => $request->cnic,
                'date_of_birth' => $request->date_of_birth,
                'phone' => $request->phone,
                'gender' => $request->gender
            ]);


            $student = $user->student()->create([
                'session_type' => $request->session_type,
                'registration_number' => $this->generateRegNumber(),
                'roll_no' => $request->roll_no ?? $user->id + 1,
                'admission_year' => Carbon::now()->year(),
            ]);

            $user->assignRole('student');

            if ($request->program) {
                $this->enrollStudent($student, $request->program);
            }
        });



        return redirect()->route('admin.users.students.index')->with('success', 'Student created successfully');
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

        $request->validate([
            'name' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'cnic' => 'required|string|min:13|max:13|unique:users,cnic,' . $user->id,
            'phone' => 'required|string|max:11',
            //add student info validation
        ]);

        $user->update([
            'name' => $request->name,
            'father_name' => $request->father_name,
            'email' => $request->email,
            'cnic' => $request->cnic,
            'phone' => $request->phone,
        ]);

        return redirect()->route('admin.users')->with('success', 'Student updated successfully');
    }
}
