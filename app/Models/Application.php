<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    public function applicant()
    {
        $this->belongsTo(Applicant::class);
    }

    public function program()
    {
        $this->belongsTo(Program::class);
    }
}
