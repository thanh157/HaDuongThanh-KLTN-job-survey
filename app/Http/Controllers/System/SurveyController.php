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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
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
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'start_time' => 'required|date',
                'end_time' => 'required|date|after_or_equal:start_time',
                'questions.*.question_text' => 'required|string',
                'questions.*.type' => 'required|in:single,multiple',
                'questions.*.options' => 'required|array|min:1',
            ], [
                'end_time.after_or_equal' => 'Ngày kết thúc không được trước ngày bắt đầu.',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $survey = Survey::create([
                'title' => $request->title,
                'description' => $request->description,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'graduation_id' => $request->graduation_id,
            ]);

            if ($request->filled('questions')) {
                foreach ($request->questions as $qIndex => $q) {
                    $options = [];

                    foreach ($q['options'] as $optIndex => $text) {
                        $options[] = [
                            'text' => $text,
                            'is_other' => isset($q['is_other'][$optIndex]) ? true : false,
                        ];
                    }

                    $survey->questions()->create([
                        'question_text' => $q['question_text'],
                        'type' => $q['type'],
                        'options' => json_encode($options),
                    ]);
                }
            }
            DB::commit();
            return redirect()->route('admin.survey.index')->with('success', 'Tạo khảo sát thành công!');
        } catch (\Exception $e) {
            Log::error($e);
            DB::rollBack();
            return redirect()->route('admin.survey.index')->with('error', 'System error');
        }
    }

    public function edit($id)
    {
        $survey = Survey::with('questions')->findOrFail($id);
        // Ép cast lại từng câu hỏi nếu cần
        $survey->questions->transform(function ($q) {
            $q->options = is_string($q->options) ? json_decode($q->options, true) : $q->options;
            return $q;
        });
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
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'start_time' => 'required|date',
                'end_time' => 'required|date|after_or_equal:start_time',
                'questions.*.question_text' => 'required|string',
                'questions.*.type' => 'required|in:single,multiple',
                'questions.*.options' => 'required|array|min:1',
            ], [
                'end_time.after_or_equal' => 'Ngày kết thúc không được trước ngày bắt đầu.',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $survey = Survey::findOrFail($id);

            $survey->update([
                'title' => $request->title,
                'description' => $request->description,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'graduation_id' => $request->graduation_id,
            ]);

            // Xoá câu hỏi cũ để ghi đè
            if ($request->questions) {
                $survey->questions()->delete();
                foreach ($request->questions as $qIndex => $q) {
                    $options = [];
                    foreach ($q['options'] as $optIndex => $text) {
                        $options[] = [
                            'text' => $text,
                            'is_other' => isset($q['is_other'][$optIndex]) ? true : false,
                        ];
                    }

                    $survey->questions()->create([
                        'question_text' => $q['question_text'],
                        'type' => $q['type'],
                        'options' => json_encode($options),
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('admin.survey.index')->with('success', 'Cập nhật khảo sát thành công!');
        } catch (\Exception $e) {
            dd($e);
            Log::error($e);
            DB::rollBack();
            return redirect()->route('admin.survey.index')->with('error', 'Lỗi');
        }
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

    public function showForm($id)
    {
        $survey = Survey::with('questions')->findOrFail($id);
        // Ép cast lại từng câu hỏi nếu cần
        $survey->questions->transform(function ($q) {
            $q->options = is_string($q->options) ? json_decode($q->options, true) : $q->options;
            return $q;
        });

        $viewData = [
            'survey' => $survey
        ];
        return view('admin.pages.admin.survey.form', $viewData);
    }
}
