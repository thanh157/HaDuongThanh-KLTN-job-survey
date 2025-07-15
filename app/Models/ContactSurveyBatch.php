<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactSurveyBatch extends Model
{
    protected $table = 'contact_survey_batches';

    protected $fillable = [
        'title',
        'description',
        'start_time',
        'end_time',
        'status', // ⚠️ Đảm bảo có dòng này
        'graduation_ceremony_ids',
    ];


    public function isActive()
    {
        return $this->status == 1;
    }

    public function isInActive()
    {
        return $this->status == 0;
    }

    public function alumniContacts()
    {
        return $this->hasMany(AlumniContact::class, 'survey_batch_id');
    }
}
