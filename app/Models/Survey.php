<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Survey extends Model
{
    protected $table = 'survey';

    use SoftDeletes;

    protected $fillable = [
        'id',
        'title',
        'description',
        'start_time',
        'end_time',
        'school_year',
        'graduation_id',
        'created_at',
        'updated_at',
    ];

    public function graduation()
    {
        return $this->belongsTo(Graduation::class, 'graduation_id', 'id');
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function surveyResponses()
    {
        return $this->hasMany(SurveyResponse::class);
    }
}
