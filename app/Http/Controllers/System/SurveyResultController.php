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
use Barryvdh\DomPDF\Facade\Pdf;

class SurveyResultController extends Controller
{
    public function index(Request $request, $surveyId)
    {
        $query = EmploymentSurveyResponse::query()
            ->with(['student'])
            ->where('survey_period_id', $surveyId);

        // Lọc theo mã sinh viên
        if ($request->filled('student_code')) {
            $query->whereHas('student', function ($q) use ($request) {
                $q->where('student_code', 'like', '%' . $request->student_code . '%');
            });
        }

        // Lọc theo tên sinh viên
        if ($request->filled('student_name')) {
            $query->whereHas('student', function ($q) use ($request) {
                $q->where('full_name', 'like', '%' . $request->student_name . '%');
            });
        }

        // Lọc theo đợt tốt nghiệp
        if ($request->filled('graduation_id')) {
            $query->where('graduation_id', $request->graduation_id);
        }

        $data = $query->orderBy('id', 'desc')->paginate(15);

        $survey = Survey::with('graduations')->findOrFail($surveyId);
        $allDotTotNghiep = $survey->graduations()->get();
        $schoolYear = !empty($allDotTotNghiep[0]->school_year) ? $allDotTotNghiep[0]->school_year : '';

        return view('admin.pages.admin.survey.result', [
            'data' => $data,
            'schoolYear' => $schoolYear,
            'allDotTotNghiep' => $allDotTotNghiep,
            'survey' => $survey,
            'request' => $request, // Gửi lại input để giữ giá trị trong form
        ]);
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
        return view('admin.pages.admin.survey.result_detail', $viewData);
    }

    public function exportPdf($survey_id)
    {
        $response = EmploymentSurveyResponse::query()
            ->with(['student', 'survey'])
            ->where('id', $survey_id)->first();
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

        $pdf = Pdf::loadView('admin.pages.admin.survey.result_detail_2', $viewData)
            ->setOptions([
                'defaultFont' => 'DejaVu Sans',
                'isHtml5ParserEnabled' => true,
                'isPhpEnabled' => true,
                'isRemoteEnabled' => true,
            ]);


        return $pdf->download('khao_sat_' . $survey_id . '.pdf');
    }
}
