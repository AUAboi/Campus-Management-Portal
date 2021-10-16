<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class StudentController extends Controller
{
  public function __construct()
  {
    $this->middleware(['role:student']);
  }

  public function index()
  {

    return  Inertia::render('Students/ProfilePage', [
      'user' => Auth::user()
    ]);
  }
}
