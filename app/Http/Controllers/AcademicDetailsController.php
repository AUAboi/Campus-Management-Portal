<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AcademicDetailsController extends Controller
{
    public function index()
    {
        return Inertia::render('Applicant/AcademicDetails/Index');
    }

    public function create()
    {

        return Inertia::render('Applicant/AcademicDetails/Create', [
            'organizations' => Organization::all(),
        ]);
    }
}
