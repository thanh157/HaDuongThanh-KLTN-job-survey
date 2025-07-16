<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Graduation;


class Survey extends Model
{
    protected $table = 'survey';

    use SoftDeletes;

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    protected $fillable = [
        'id',
        'title',
        'description',
        'status',
        'start_time',
        'end_time',
        'school_year',
        'created_at',
        'updated_at',
    ];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function surveyResponses()
    {
        return $this->hasMany(SurveyResponse::class);
    }

    public function employmentSurveyResponse()
    {
        return $this->hasMany(EmploymentSurveyResponse::class, 'survey_period_id');
    }

    // public function graduations()
    // {
    //     return $this->belongsToMany(Graduation::class, 'graduation_survey');
    // }
    public function graduations()
    {
        return $this->belongsToMany(Graduation::class, 'graduation_survey', 'survey_id', 'graduation_id');
    }

    public function isActive()
    {
        return $this->status == self::STATUS_ACTIVE;
    }

    public function isInActive()
    {
        return $this->status == self::STATUS_INACTIVE;
    }

}
