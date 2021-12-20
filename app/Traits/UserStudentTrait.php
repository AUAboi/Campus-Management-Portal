<?php

namespace App\Traits;

use Carbon\Carbon;
use App\Models\Student;

trait UserStudentTrait
{

  public function createStudent($user, $request)
  {
    $user->student()->create([
      'registration_number' => $this->generateRegNumber(),
      'session_type' => $request->session_type ?? 'evening',
      'roll_no' => $user->id + 1000,
      'admission_year' => Carbon::now()->year,
      'cgpa' => 0.00
    ]);
  }

  public function generateRegNumber()
  {
    //Format: random 5 digits
    //append with admission year and branch name like
    // branch-year-registration

    $reg_number = rand(1, 9)  . rand(1, 9)   . rand(1, 9)  . rand(1, 9) .  rand(1, 9);
    if (Student::where('registration_number', $reg_number)->where('admission_year', Carbon::now()->year)->exists()) {
      $this->generateRegNumber();
    }
    return $reg_number;
  }
}
