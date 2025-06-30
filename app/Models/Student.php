<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'student'; // tên bảng tương ứng trong database

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'int';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'last_name',
        'first_name',
        'full_name',
        'email',
        'code',
        'training_industry_id',
        'created_at',
        'updated_at',
    ];
}

