<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'department_name',
        'slug',
        'faculty_id'
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }


    public function programs()
    {
        return $this->hasMany(Program::class);
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('department_name', 'like', '%' . $search . '%');
        });
    }
}
