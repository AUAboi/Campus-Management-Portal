<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('program_name', 'like', '%' . $search . '%');
        });
    }
}
