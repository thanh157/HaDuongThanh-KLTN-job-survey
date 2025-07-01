<?php

namespace App\Http\Controllers;

use App\Models\Graduation;
use App\Models\GraduationStudent;
use App\Models\Student;
use App\Models\Survey;
use App\Models\SurveyAnswers;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

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
        $request->validate([
            'survey_id' => 'required|exists:surveys,id',
            'student_id' => 'required|exists:students,id',
            'answers' => 'required|array',
        ]);

        foreach ($request->answers as $questionId => $answer) {
            $values = is_array($answer) ? $answer : [$answer];

            foreach ($values as $val) {
                SurveyAnswers::create([
                    'survey_id' => $request->survey_id,
                    'student_id' => $request->student_id,
                    'question_id' => $questionId,
                    'answer_text' => $val,
                ]);
            }

            // ✅ Nếu có nội dung "Khác"
            if ($request->filled("answers_other.$questionId")) {
                SurveyAnswers::create([
                    'survey_id' => $request->survey_id,
                    'student_id' => $request->student_id,
                    'question_id' => $questionId,
                    'answer_text' => $request->input("answers_other.$questionId"),
                ]);
            }
        }

        return redirect()->route('survey.thankyou');
    }
}
