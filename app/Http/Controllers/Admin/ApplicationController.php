<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ApplicationResource;
use App\Models\Application;

class ApplicationController extends Controller
{


  public function index(Request $request)
  {
    $filters = $request->all('search');

    $applications = Application::orderBy('created_at', 'DESC')
      ->with(['applicant', 'program', 'program.department', 'program.degree', 'status'])
      ->filter($request->only('search'))
      ->paginate(10)
      ->withQueryString();

    return Inertia::render('Admin/Applications/Index', [
      'applications' =>  ApplicationResource::collection($applications),
      'filters' => $filters,
    ]);
  }
}
