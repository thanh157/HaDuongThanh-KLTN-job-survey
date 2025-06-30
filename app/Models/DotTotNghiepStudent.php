<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DotTotNghiepStudent extends Model
{
    protected $table = 'dot_tot_nghiep_student';

    public $timestamps = false;

    protected $fillable = [
        'student_id',
        'dot_tot_nghiep_id',
    ];
}
