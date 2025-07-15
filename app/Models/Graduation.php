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

    public function students()
    {
        return $this->belongsToMany(Student::class, 'graduation_student', 'graduation_id', 'student_id');
    }

    public function surveys()
    {
        return $this->belongsToMany(Survey::class, 'graduation_survey', 'graduation_id', 'survey_id');
    }

    public function contactSurveys()
    {
        return $this->belongsToMany(ContactSurvey::class, 'contact_survey_graduation', 'graduation_id', 'contact_survey_id');
    }
}
