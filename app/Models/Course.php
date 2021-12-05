<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_name',
        'course_code',
        'practical_credit_hours',
        'theory_credit_hours',
        'department_code'
    ];


    public function programs()
    {
        return $this->belongsToMany(Program::class)->withPivot('semester');
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('course_name', 'like', '%' . $search . '%');
        });
    }
}
