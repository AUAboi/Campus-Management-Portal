<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware(['role:admin']);
    }

    public function index(Request $request)
    {
        $user = User::find($request->user()->id);

        return  Inertia::render('Admin/Profile/Index', [
            'user' => $user,
        ]);
    }
}
