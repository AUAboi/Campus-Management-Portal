<?php

namespace App\Models;

use App\Models\Degree;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'program_name',
        'program_duration',
        'slug'
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function degree()
    {
        return $this->belongsTo(Degree::class);
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->whereHas('degree', function ($query) use ($search) {
                $query->where('degree_name', 'like', "%{$search}%");
            })->orWhereHas('department', function ($query) use ($search) {
                $query->where('department_name', 'like', "%{$search}%");
            });
        });
    }
}
