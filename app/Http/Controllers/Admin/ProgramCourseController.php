<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Course;
use App\Models\Faculty;
use App\Models\Program;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class ProgramCourseController extends Controller
{
    public function index(Program $program, $semester)
    {
        $this->authorize('update', $program);

        $courses =  Course::orderBy('course_name')
            ->get()
            ->transform(fn ($course) => [
                'id' => $course->id,
                'course_name' => $course->course_name,
                'course_code' => $course->course_code,
                'theory_credit_hours' => $course->theory_credit_hours,
                'practical_credit_hours' => $course->practical_credit_hours,
                'department_code' => $course->department_code,
                'belongs_to_program' => $program->courses()->where('course_id', $course->id)->where('semester', $semester)->exists(),
            ]);


        return Inertia::render('Admin/Programs/AddCourse', [
            'semester' => $semester,
            'program' => $program,
            'courses' => $courses,
            'permissions' => [
                'create' => auth()->user()->can('create', Faculty::class),
            ]
        ]);
    }

    public function store(Request $request, Program $program, $semester)
    {

        $this->authorize('update', $program);

        $courses = $request->courses;

        $selected_courses = array_column(array_filter($courses, function ($course) {
            return $course['belongs_to_program'] == true;
        }), 'id');


        $program->courses()->wherePivot('semester', '=', $semester)->detach();

        $program->courses()->attach($selected_courses, ['semester' => $semester]);

        return Redirect::route('admin.programs.edit', $program->slug)->with('success', 'Courses added successfully');
    }
}
