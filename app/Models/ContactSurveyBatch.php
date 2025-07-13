<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactSurveyBatch extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'start_time',
        'end_time',
    ];

    public function alumniContacts()
    {
        return $this->hasMany(AlumniContact::class, 'survey_batch_id');
    }
}
