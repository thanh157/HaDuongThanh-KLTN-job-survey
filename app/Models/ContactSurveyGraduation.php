<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactSurveyGraduation extends Model
{
    protected $table = 'contact_survey_graduation';

    protected $fillable = [
        'contact_survey_id',
        'graduation_id',
    ];
}
