<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyAnswer extends Model
{
    use HasFactory;

    protected $table = 'survey_answers';

    protected $fillable = [
        'survey_response_id',
        'question_id',
        'answer_text',
    ];

    public function response()
    {
        return $this->belongsTo(SurveyResponse::class, 'survey_response_id');
    }

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }
}
