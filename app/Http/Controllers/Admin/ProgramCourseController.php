<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Course;
use App\Models\Faculty;
use App\Models\Program;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

use function PHPSTORM_META\map;

class ProgramCourseController extends Controller
{
    public function index(Program $program, $semester)
    {
        $this->authorize('update', $program);


        if ($semester > $program->degree->semesters) {
            return Redirect::back()->with('error', 'Semester is not available.');
        }

        $program_courses = $program->courses()->where('semester', $semester)->get();
        $courses =  Course::orderBy('course_name')
            ->get()
            ->transform(fn ($course) => [
                'id' => $course->id,
                'course_name' => $course->course_name,
                'course_code' => $course->course_code,
                'theory_credit_hours' => $course->theory_credit_hours,
                'practical_credit_hours' => $course->practical_credit_hours,
                'department_code' => $course->department_code,
                'belongs_to_program' => $program_courses->contains($course->id),
                'total_credit_hours' => $course->credit_hours,
            ]);

        return Inertia::render('Admin/Programs/AddCourse', [
            'semester' => $semester,
            'program' => $program,
            'courses' => $courses,
            'program_courses' => $program_courses,
            'permissions' => [
                'update' => auth()->user()->can('update', Program::class),
            ]
        ]);
    }

    public function store(Request $request, Program $program, $semester)
    {
        $this->authorize('update', $program);

        $request->validate([
            'courses' => 'required|array|min:1',
        ]);

        if ($semester > $program->degree->semesters) {
            return Redirect::back()->withErrors(['The semester you selected is not available for this program.']);
        }

        //Our frontend form will send us all courses
        $courses = $request->courses;


        //Filter where course belongs to program, and grab course ids
        $selected_courses = array_column(array_filter($courses, function ($course) {
            return $course['belongs_to_program'] == true;
        }), 'id');


        //Detaching course where semester is given semester from program
        $program->courses()->wherePivot('semester', '=', $semester)->detach();


        //Attach courses sent from frontend to program with given semester
        $program->courses()->attach($selected_courses, ['semester' => $semester]);

        return Redirect::route('admin.programs.edit', $program->slug)->with('success', 'Courses added successfully');
    }
}
