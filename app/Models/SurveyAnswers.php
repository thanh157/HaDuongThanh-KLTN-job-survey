<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SurveyAnswers extends Model
{
    protected $table = 'graduation'; // tên bảng tương ứng trong database
    use SoftDeletes;

    protected $fillable = [
        'survey_id',
        'student_id',
        'question_id',
        'answer_text',
    ];
}
