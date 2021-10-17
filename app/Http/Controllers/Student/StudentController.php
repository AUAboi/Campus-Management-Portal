<?php

namespace App\Http\Controllers\Student;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
  public function __construct()
  {
    $this->middleware(['role:student']);
  }

  public function index(Request $request)
  {
    $user = User::with('student')->findOrFail($request->user()->id);

    return  Inertia::render('Students/ProfilePage', [
      'user' => $user,
    ]);
  }
}
