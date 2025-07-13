<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GraduationSurvey extends Model
{
    protected $table = 'graduation_survey';

    public $timestamps = false;

    protected $fillable = [
        'survey_id',
        'graduation_id',
    ];
}
