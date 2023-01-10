<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'title',
        'exam_type',
        'reg_no',
        'passing_year',
        'oraganization',
        'obtained_marks',
        'user_id'
    ];

    public function applicant()
    {
        $this->belongsTo(User::class);
    }
}
