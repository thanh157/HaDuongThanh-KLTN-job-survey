<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactSurvey extends Model
{
    protected $table = 'contact_surveys';

    protected $fillable = [
        'title',
        'description',
        'start_time',
        'end_time',
        'status'
    ];

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    public function graduations()
    {
        return $this->belongsToMany(Graduation::class, 'contact_survey_graduation', 'contact_survey_id', 'graduation_id');
    }

    public function alumniContacts()
    {
        return $this->hasMany(AlumniContact::class, 'survey_batch_id');
    }

    public function isActive()
    {
        return $this->status == \App\Models\Survey::STATUS_ACTIVE;
    }

    public function isInActive()
    {
        return $this->status == \App\Models\Survey::STATUS_INACTIVE;
    }
}
