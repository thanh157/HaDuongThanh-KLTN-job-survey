<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Graduation extends Model
{
    protected $table = 'graduations'; // tên bảng tương ứng trong database

    protected $fillable = [
        'dot_tot_nghiep',
        'nam_tot_nghiep',
        'tong_sinh_vien',
    ];
}
