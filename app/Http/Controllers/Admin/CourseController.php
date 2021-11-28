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
            ->withQueryString();

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
            'course_code' => 'unique:courses,course_code',
            'practical_credit_hours' => 'required|numeric',
            'theory_credit_hours' => 'required|numeric',
            'department_code' => 'required',
        ]);

        $course = Course::create($request->all());

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
}
