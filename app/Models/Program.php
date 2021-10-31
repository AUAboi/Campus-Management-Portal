<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'program_name',
        'program_duration'
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
