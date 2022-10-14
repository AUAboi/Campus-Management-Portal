<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Course;
use App\Models\Faculty;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->all('search');

        $courses =  Course::orderBy('course_name')
            ->filter($request->only('search'))
            ->paginate(10)
            ->withQueryString()
            ->through(
                fn ($course) => [
                    'id' => $course->id,
                    'course_name' => $course->course_name,
                    'course_code' => $course->full_course_code,
                    'credit_hours' => $course->credit_hours,
                ]
            );

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

    public function store(StoreCourseRequest $request)
    {
        $this->authorize('create', Course::class);
        Course::create($request->validated());

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

    public function update(UpdateCourseRequest $request, Course $course)
    {
        $this->authorize('update', $course);

        $course->update($request->validated());

        return redirect()->route('admin.courses')->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course)
    {
        $this->authorize('delete', $course);

        $course->delete();

        return redirect()->route('admin.courses')->with('success', 'Course deleted successfully.');
    }
}
