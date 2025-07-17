<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\Survey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\Graduation;

class SurveyController extends Controller
{
    public function index()
    {
        $data = Survey::with(['graduations', 'employmentSurveyResponse'])->paginate(10);
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
                'graduation_id' => 'required|array|min:1',
                'start_time' => 'required|date',
                'end_time' => 'bail|required|date|after_or_equal:start_time|after:now',
            ], [
                'end_time.after_or_equal' => 'Thời gian kết thúc không được trước thời gian bắt đầu.',
                'end_time.after' => 'Thời gian kết thúc phải lớn hơn hiện tại.',
                'graduation_id.required' => 'Vui lòng chọn ít nhất một đợt tốt nghiệp.',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $survey = Survey::create([
                'title' => $request->title,
                'description' => $request->description,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'status' => Survey::STATUS_ACTIVE
            ]);

            $survey->graduations()->attach($request->graduation_id);

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
        $survey = Survey::with('graduations')->findOrFail($id);

        // Lấy danh sách năm tốt nghiệp duy nhất
        $namTotNghiep = Graduation::select('school_year')->distinct()->orderBy('school_year', 'desc')->pluck('school_year');

        // Lấy tất cả đợt tốt nghiệp
        $allDotTotNghiep = Graduation::orderBy('school_year', 'desc')->get();

        // Lấy các ID đợt tốt nghiệp đã được chọn
        $selectedGraduationIds = $survey->graduations->pluck('id')->toArray();

        return view('admin.pages.admin.survey.edit', compact(
            'survey',
            'namTotNghiep',
            'allDotTotNghiep',
            'selectedGraduationIds'
        ));
    }


    public function update($id, Request $request)
    {
        DB::beginTransaction();
        try {
            $rules = [
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'start_time' => 'required|date',
                'end_time' => 'required|date|after_or_equal:start_time',
                'status' => 'required|in:0,1',
            ];

            // Nếu đang bật khảo sát → bắt buộc phải chọn đợt tốt nghiệp
            if ($request->status == 1) {
                $rules['graduation_id'] = 'required|array|min:1';
            }

            $validated = $request->validate($rules, [
                'graduation_id.required' => 'Vui lòng chọn ít nhất một đợt tốt nghiệp.',
                'end_time.after_or_equal' => 'Thời gian kết thúc không được trước thời gian bắt đầu.',
            ]);

            $survey = Survey::findOrFail($id);

            $survey->update([
                'title' => $request->title,
                'description' => $request->description,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'status' => $request->status,
            ]);

            if ($request->status == 1) {
                $graduationIds = $request->graduation_id ?? $survey->graduations->pluck('id')->toArray();
                $survey->graduations()->sync($graduationIds);
            }

            DB::commit();
            return redirect()->route('admin.survey.index')->with('success', 'Cập nhật khảo sát thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            return redirect()->route('admin.survey.index')->with('error', 'Lỗi cập nhật khảo sát');
        }
    }


    public function destroy($id)
    {
        try {
            $survey = Survey::query()->findOrFail($id);

            // Xóa liên kết đợt tốt nghiệp trong pivot
            $survey->graduations()->detach();

            // Xóa khảo sát chính
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

    public function getDotTotNghiep()
    {
        $nam = request('school_year');
        $data = Graduation::query()->where('school_year', $nam)->get();
        return response()->json($data);
    }
}
