<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    protected $table = 'question';

    use SoftDeletes;

    protected $casts = [
        'options' => 'array',
    ];

    protected $fillable = [
        'survey_id',
        'question_text',
        'type',
        'options',
        'created_at',
        'updated_at',
    ];

    public function survey()
    {
        return $this->belongsTo(Survey::class, 'survey_id', 'id');
    }
}
