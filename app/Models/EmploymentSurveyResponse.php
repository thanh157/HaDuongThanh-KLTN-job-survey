<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmploymentSurveyResponse extends Model
{
    protected $table = 'employment_survey_responses_v2';

    protected $fillable = [
        'graduation_id',
        'survey_period_id',
        'student_id',
        'email',
        'full_name',
        'dob',
        'gender',
        'code_student',
        'identification_card_number',
        'identification_card_number_update',
        'identification_issuance_place',
        'identification_issuance_date',
        'training_industry_id',
        'course',
        'phone_number',
        'employment_status',
        'recruit_partner_name',
        'recruit_partner_address',
        'recruit_partner_date',
        'recruit_partner_position',
        'work_area',
        'employed_since',
        'trained_field',
        'professional_qualification_field',
        'level_knowledge_acquired',
        'starting_salary',
        'average_income',
        'recruitment_type',
        'job_search_method',
        'soft_skills_required',
        'must_attended_courses',
        'solutions_get_job',
        'city_work_id',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }
    public function survey()
    {
        return $this->belongsTo(Survey::class, 'survey_period_id', 'id');
    }
}
