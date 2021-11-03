<?php

namespace App\Http\Controllers\Admin;

use App\Models\Faculty;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Inertia\Inertia;

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
}
