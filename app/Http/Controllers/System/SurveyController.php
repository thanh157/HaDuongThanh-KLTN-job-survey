<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\DotTotnghiep;
use App\Models\DotTotNghiepStudent;
use App\Models\GraduationStudent;
use App\Models\Student;
use App\Models\Survey;
use Illuminate\Http\Request;
use App\Services\StudentService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use App\Models\Graduation;

class SurveyController extends Controller
{
    public function index()
    {
        $data = Survey::with('graduation')->get();
        $viewData = [
            'data' => $data
        ];
        return view('admin.pages.admin.survey.index', $viewData);
    }

    public function create()
    {
        $namTotNghiep = Graduation::select('school_year')->groupBy('school_year')->pluck('school_year')->toArray();
        $dotTotNghiep = Graduation::get();

        $viewData = [
            'namTotNghiep' => $namTotNghiep,
            'dotTotNghiep' => $dotTotNghiep,
        ];

        return view('admin.pages.admin.survey.create', $viewData);
    }

    public function store(Request $request)
    {
        $request->validate([
            'start_time' => 'required|date',
            'end_time' => 'required|date|after_or_equal:start_time',
        ]);

        $survey = Survey::create([
            'title' => $request->title,
            'description' => $request->description,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'graduation_id' => $request->graduation_id,
        ]);

        return redirect()->route('admin.survey.index')->with('success', 'Tạo khảo sát thành công!');
    }

    public function edit($id)
    {
        $survey = Survey::query()->findOrFail($id);
        $namTotNghiep = Graduation::select('school_year')->groupBy('school_year')->pluck('school_year')->toArray();
        $dotTotNghiep = Graduation::get();
        $viewData = [
            'survey' => $survey,
            'namTotNghiep' => $namTotNghiep,
            'dotTotNghiep' => $dotTotNghiep,
        ];
        return view('admin.pages.admin.survey.edit', $viewData);
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'start_time' => 'required|date',
            'end_time' => 'required|date|after_or_equal:start_time',
        ]);

        $survey = Survey::findOrFail($id);

        $survey->update([
            'title' => $request->title,
            'description' => $request->description,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'graduation_id' => $request->graduation_id,
        ]);

        return redirect()->route('admin.survey.index')->with('success', 'Cập nhật khảo sát thành công!');
    }

    public function destroy($id)
    {
        try {
            $survey = Survey::query()->findOrFail($id);
            $survey->delete();

            return redirect()->route('admin.survey.index')->with('success', 'Đã xoá khảo sát thành công!');
        } catch (\Exception $e) {
            Log::error($e);
            return redirect()->route('admin.survey.index')->with('error', 'Lỗi');
        }
    }
}
