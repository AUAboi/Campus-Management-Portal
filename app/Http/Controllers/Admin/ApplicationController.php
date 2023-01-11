<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApplicationResource;
use App\Models\Application;
use App\Models\ApplicationStatus;

class ApplicationController extends Controller
{
  public function index(Request $request)
  {
    $filters = $request->all('search', 'status');

    $applications = Application::orderBy('created_at', 'DESC')
      ->with(['applicant', 'program', 'program.department', 'program.degree', 'status'])
      ->availableTo(auth()->user())
      ->filter($request->only('search', 'status'))
      ->paginate(10)
      ->withQueryString();

    return Inertia::render('Admin/Applications/Index', [
      'statuses' => ApplicationStatus::all(),
      'applications' =>  ApplicationResource::collection($applications),
      'filters' => $filters,
    ]);
  }
}
