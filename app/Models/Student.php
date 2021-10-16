<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_duration',
        'session_type',
        'registration_number',
        'roll_no',
        'admission_year',
        'cgpa'
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
