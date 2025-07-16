<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    protected $table = 'student'; // tên bảng tương ứng trong database

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'int';
    public $timestamps = false;
    use SoftDeletes;

    protected $fillable = [
        'id',
        'last_name',
        'first_name',
        'full_name',
        'email',
        'code',
        'training_industry_id',
        'citizen_identification',
        'phone',
        'dob',
        'gender',
        'school_year_end',
        'created_at',
        'updated_at',
    ];

    public function graduations()
    {
        return $this->belongsToMany(Graduation::class, 'graduation_student', 'student_id', 'graduation_id');
    }

    public function graduation()
    {
        return $this->belongsTo(Graduation::class);
    }

    public function trainingIndustry()
    {
        return $this->belongsTo(Major::class, 'training_industry_id');
    }
    
}
