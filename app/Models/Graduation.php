<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Graduation extends Model
{
    protected $table = 'graduation'; // tên bảng tương ứng trong database
    use SoftDeletes;

    protected $fillable = [
        'id',
        'name',
        'certification',
        'certification_date',
        'student_count',
        'school_year',
        'faculty_id',
        'created_at',
        'updated_at',
    ];
}
