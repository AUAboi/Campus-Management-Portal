<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Course;
use App\Models\Faculty;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->all('search');

        $courses =  Course::orderBy('course_name')
            ->filter($request->only('search'))
            ->paginate(10)
            ->withQueryString()
            ->through(fn ($course) => [
                'id' => $course->id,
                'course_name' => $course->course_name,
                'course_code' => $course->course_code,
                'department_code' => $course->department_code,
                'credit_hours' => $course->credit_hours,
            ]);



        return Inertia::render('Admin/Courses/Index', [
            'courses' => $courses,
            'filters' => $filters,
            'permissions' => [
                'create' => auth()->user()->can('create', Faculty::class),
            ]
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Courses/Create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'course_name' => 'required|unique:courses,course_name',
            'course_code' => 'required|numeric|max:999|min:100',
            'practical_credit_hours' => 'required|numeric',
            'theory_credit_hours' => 'required|numeric',
            'department_code' => 'required',
        ]);

        $course = Course::create($request->only([
            'course_name',
            'course_code',
            'practical_credit_hours',
            'theory_credit_hours',
            'department_code',
        ]));

        return redirect()->route('admin.courses')->with('success', 'Course created successfully.');
    }

    public function edit(Course $course)
    {
        $this->authorize('update', $course);

        return Inertia::render("Admin/Courses/Edit", [
            'course' => $course,
            'permissions' => [
                'delete' => auth()->user()->can('delete_faculties'),
            ],
        ]);
    }

    public function update(Request $request, Course $course)
    {
        $this->authorize('update', $course);

        $this->validate($request, [
            'course_name' => 'required|unique:courses,course_name,' . $course->id,
            'course_code' => 'required|numeric|max:999|min:100',
            'practical_credit_hours' => 'required|numeric',
            'theory_credit_hours' => 'required|numeric',
            'department_code' => 'required',
        ]);

        $course->update($request->only([
            'course_name',
            'course_code',
            'practical_credit_hours',
            'theory_credit_hours',
            'department_code',
        ]));

        return redirect()->route('admin.courses')->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course)
    {
        $this->authorize('delete', $course);

        $course->delete();

        return redirect()->route('admin.courses')->with('success', 'Course deleted successfully.');
    }
}
