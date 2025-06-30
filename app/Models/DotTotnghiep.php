<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DotTotnghiep extends Model
{
    protected $table = 'dot_tot_nghiep';

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'name',
        'certification',
        'certification_date',
        'school_year',
        'faculty_id',
        'created_at',
        'updated_at',
    ];
}
