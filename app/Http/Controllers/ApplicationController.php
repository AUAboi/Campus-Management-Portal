<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class ApplicationController extends Controller
{
    public function __construct()
    {
        //add middlewares
    }

    public function index(Request $request)
    {
        $applications = $request->user()->applicant->applications()->with(['program', 'program.department', 'program.degree'])->get()->transform(fn ($application) => [
            'program' => $application->program->full_program_name,
        ]);

        return Inertia::render('Applicant/Applications/Index', [
            'applications' => $applications,
        ]);
    }
}