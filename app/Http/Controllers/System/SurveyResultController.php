<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\DotTotnghiep;
use App\Models\DotTotNghiepStudent;
use App\Models\GraduationStudent;
use App\Models\Student;
use App\Models\Survey;
use App\Models\SurveyResponse;
use Illuminate\Http\Request;
use App\Services\StudentService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use App\Models\Graduation;

class SurveyResultController extends Controller
{
    public function index($surveyId)
    {
        $survey = Survey::query()->with('questions')->findOrFail($surveyId);
        $responses = SurveyResponse::with(['answers', 'survey'])
            ->where('survey_id', $surveyId)
            ->latest()
            ->get();

        $survey->questions->transform(function ($q) {
            $q->options = is_string($q->options) ? json_decode($q->options, true) : $q->options;
            return $q;
        });

        $questions = $survey->questions; // Nếu có quan hệ ->questions

        return view('admin.pages.admin.survey.result', compact('survey', 'responses', 'questions'));
    }
}
