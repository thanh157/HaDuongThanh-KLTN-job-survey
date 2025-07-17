<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlumniContact extends Model
{
    use HasFactory;

    protected $table = 'alumni_contact_surveys';

    protected $fillable = [
        'student_code',
        'course',
        'full_name',
        'gender',
        'date_of_birth',
        'place_of_birth',
        'address',
        'phone',
        'email',
        'facebook',
        'instagram',
        'company_name',
        'company_address',
        'company_phone',
        'company_email',
        'survey_batch_id',
    ];

    public function surveyBatch()
    {
        return $this->belongsTo(ContactSurveyBatch::class, 'survey_batch_id');
    }
}
