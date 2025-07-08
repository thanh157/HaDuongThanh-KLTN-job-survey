<?php

namespace App\Http\Controllers;

use App\Models\Graduation;
use App\Models\GraduationStudent;
use App\Models\Student;
use App\Models\Survey;
use App\Models\SurveyAnswer;
use App\Models\SurveyAnswers;
use App\Models\SurveyResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class KhaoSatController extends Controller
{
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
        return view('admin.pages.admin.my_form', $viewData);
    }

    public function verify(Request $request)
    {
        try {
            $code = request('mssv');
            $graduationId = request('graduation_id');

            $student = Student::where('code', $code)
                ->whereHas('graduations', function ($q) use ($graduationId) {
                    $q->where('graduation_id', $graduationId);
                })
                ->first();

            if ($student) {
                return response()->json([
                    'success' => true,
                    'student' => [
                        'id' => $student->id,
                        'ho_ten' => $student->full_name,
                        'ma_sv' => $student->code,
                        'email' => $student->email,
                    ],
                ]);
            }
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json([
                'success' => false,
                'message' => 'Mã sinh viên không hợp lệ hoặc không thuộc đợt tốt nghiệp này.',
            ]);
        }
    }

    public function submit(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'survey_id' => 'required|exists:survey,id',
                'answers' => 'required|array',
            ], [], [
                'answers' => 'Nội dung khảo sát'
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            // Bước 1: lưu lượt nộp khảo sát
            $response = SurveyResponse::create([
                'survey_id' => $request->survey_id,
                'student_id' => $request->student_id,
                'ma_sv'      => $request->ma_sv,
                'ho_ten'     => $request->ho_ten,
                'email'      => $request->email,
                'phone'      => $request->phone,
                'student_info' => json_encode($request->only([
                    'gender','birthday','cccd','ngay_cap','noi_cap','khoa_hoc',
                    'major','vieclam_hientai','coquan','dia_chi_co_quan','thanhpho','chucvu'
                ])),
                'submitted_at' => now(),
            ]);

// Bước 2: lưu các câu trả lời
            foreach ($request->answers as $questionId => $answers) {
                $values = is_array($answers) ? $answers : [$answers];

                foreach ($values as $val) {
                    if (strtolower($val) === 'khác' && $request->filled("answers_other.$questionId")) {
                        continue;
                    }

                    SurveyAnswer::create([
                        'survey_response_id' => $response->id,
                        'question_id' => $questionId,
                        'answer_text' => $val,
                    ]);
                }

                // Nếu có phần "Khác"
                if ($request->has("answers_other.$questionId")) {
                    $others = (array) $request->input("answers_other.$questionId");

                    foreach ($others as $otherVal) {
                        if (trim($otherVal)) {
                            SurveyAnswer::create([
                                'survey_response_id' => $response->id,
                                'question_id' => $questionId,
                                'answer_text' => $otherVal,
                            ]);
                        }
                    }
                }
            }

            return redirect()->route('survey.thankyou')->with('success', 'Ghi nhận khảo sát thành công!');
        } catch (\Exception $e) {
            Log::error($e);
            return redirect()->back()->with('error', 'System error');
        }
    }
}
