<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\DotTotnghiep;
use App\Models\DotTotNghiepStudent;
use App\Models\EmploymentSurveyResponse;
use App\Models\GraduationStudent;
use App\Models\Major;
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
       $data = EmploymentSurveyResponse::query()->with(['student'])->where('survey_period_id', $surveyId)->orderBy('id', 'desc')->paginate(15);
       $viewData = [
           'data' => $data
       ];
       return view('admin.pages.admin.survey.result', $viewData);
    }

    public function show($id)
    {
        $response = EmploymentSurveyResponse::query()
            ->with(['student', 'survey'])
            ->where('id', $id)->first();
        if (empty($response)) {
            abort(404);
        }

        $major = Major::query()->pluck('name', 'id')->toArray();

        $viewData = [
            'response' => $response,
            'student' => $response->student,
            'survey' => $response->survey,
            'major' => $major,
        ];
//        dd(json_decode($response->job_search_method, true));
        return view('admin.pages.admin.survey.result_detail', $viewData);
    }
}
