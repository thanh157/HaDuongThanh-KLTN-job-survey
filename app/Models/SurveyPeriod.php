<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyPeriod extends Model
{
    use HasFactory;

    protected $table = 'survey_periods';

    protected $fillable = [
        'title',
        'description',
        'start_time',
        'end_time',
        'year',
        'status',
    ];
}
