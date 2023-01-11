<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'program_id',
        'status_id',
        'user_id'
    ];

    public function applicant()
    {
        return $this->belongsTo(User::class);
    }

    public function program()
    {
        return  $this->belongsTo(Program::class);
    }

    public function status()
    {
        return $this->belongsTo(ApplicationStatus::class);
    }
}
