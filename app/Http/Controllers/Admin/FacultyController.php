<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Faculty;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class FacultyController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:admin']);
    }

    public function index()
    {
        $faculties = Faculty::all()->sortBy('faculty_name');

        return Inertia::render("Admin/Faculties/Index", ['faculties' => $faculties]);
    }

    public function create()
    {
        return Inertia::render("Admin/Faculties/Create");
    }

    public function store(Request $request)
    {
        $request->validate([
            'faculty_name' => 'required|unique:faculties,faculty_name',
        ]);

        Faculty::create($request->only('faculty_name'));
        return Redirect::route('admin.faculties')->with('success', 'Organization created.');
    }
}
