<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GraduationStudent extends Model
{
    protected $table = 'graduation_student';

    public $timestamps = false;

    protected $fillable = [
        'student_id',
        'graduation_id',
    ];
}
