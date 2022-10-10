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

    public function index(Request $user)
    {
        $applications = $user->applicant->applications->through(
            fn ($application) => [
                'program' => $application->program->get_full_program_name,
            ]
        );

        return Inertia::render('Applicants/Applications/Index');
    }
}
