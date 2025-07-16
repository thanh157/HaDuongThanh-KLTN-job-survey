<?php

namespace App\Http\Controllers;

use App\Models\ContactSurvey;
use App\Models\EmploymentSurveyResponse;
use App\Models\Major;
use App\Models\Student;
use App\Models\Survey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class KhaoSatController extends Controller
{
    public function showForm($id)
    {
        $survey = Survey::with('questions')->findOrFail($id);
        if ($survey->isInActive()) {
            abort(404);
        }
        $student = Student::where('code', 596606)->first();
        $major = Major::query()->get();

        $end_time = $survey->end_time;
        $current_time = date('Y-m-d H:i:s');

        $outDate = strtotime($current_time) > strtotime($end_time);
        $viewData = [
            'survey' => $survey,
            'student' => $student,
            'major' => $major,
            'outDate' => $outDate,
        ];
        return view('admin.pages.admin.my_form', $viewData);
    }

    public function verify(Request $request)
    {
        try {
            $surveyId = $request->input('survey_id');
            $code = $request->input('mssv');
            $email = $request->input('email');
            $phone = $request->input('phone');
            $dob = $request->input('dob');
            $cccd = $request->input('citizen_identification');
            $industry_id = $request->input('training_industry_id');

            // Kiểm tra mã sinh viên có nhập không
            if (empty($code)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vui lòng nhập mã sinh viên (MSSV)',
                ]);
            }

            // Kiểm tra survey có tồn tại không
            $survey = Survey::find($surveyId);
            if (empty($survey)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Khảo sát không tồn tại',
                ]);
            }

            $graduationIds = $survey->graduations()->pluck('id')->toArray();

            $student = Student::query()
                ->where('code', $code)
                ->whereHas('graduations', function ($q) use ($graduationIds) {
                    $q->whereIn('graduation_id', $graduationIds);
                })
                ->first();

            if (!$student) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không tìm thấy sinh viên có mã này trong khảo sát',
                ]);
            }

            $invalidFields = [];

            if (!empty($email) && $student->email !== $email) {
                $invalidFields[] = 'email';
            }

            if (!empty($dob) && $student->dob !== $dob) {
                $invalidFields[] = 'dob';
            }

            if (!empty($phone) && $student->phone_number !== $phone) {
                $invalidFields[] = 'phone';
            }

            if (!empty($cccd) && $student->identification_card_number !== $cccd) {
                $invalidFields[] = 'citizen_identification';
            }

            if (!empty($industry_id) && $student->training_industry_id != $industry_id) {
                $invalidFields[] = 'training_industry_id';
            }

            if (count($invalidFields) > 0) {
                return response()->json([
                    'success' => false,
                    'invalid_fields' => $invalidFields,
                    'message' => 'Thông tin xác thực không khớp: ' . implode(',', $invalidFields),
                ]);
            }

            return response()->json([
                'success' => true,
                'student' => $student,
            ]);
        } catch (\Exception $e) {
            Log::error($e);
            return response()->json([
                'success' => false,
                'message' => 'Mã sinh viên không hợp lệ hoặc không thuộc đợt tốt nghiệp này.',
            ]);
        }
    }

    public function verifyV2(Request $request)
    {
        try {
            $surveyId = $request->input('survey_id');

            $code = $request->input('m_mssv');
            $phone = $request->input('m_phone');
            $email = $request->input('m_email');
            $dob = $request->input('m_dob');
            $industry_id = $request->input('training_industry');

            // Kiểm tra mã sinh viên có nhập không
            if (empty($code)) {
                return redirect()->back()->with('error', 'Vui lòng nhập mã sinh viên (MSSV)');
            }

            // Kiểm tra survey có tồn tại không
            $survey = ContactSurvey::find($surveyId);
            if (empty($survey)) {
                return redirect()->back()->with('error', 'Khảo sát không tồn tại');
            }

            $student = Student::query()
                ->where('code', $code)
                ->first();

            if (!$student) {
                return redirect()->back()->with('error', 'Không tìm thấy sinh viên có mã này trong khảo sát')->withInput();
            }

            $invalidFields = [];

            if (!empty($email) && $student->email !== $email) {
                $invalidFields[] = 'email';
            }

            if (!empty($dob) && $student->dob !== $dob) {
                $invalidFields[] = 'dob';
            }

            if (!empty($phone) && $student->phone_number !== $phone) {
                $invalidFields[] = 'phone';
            }

            if (!empty($industry_id) && $student->training_industry_id != $industry_id) {
                $invalidFields[] = 'training_industry_id';
            }

            if (count($invalidFields) > 0) {
                return redirect()->back()->with('error', 'Thông tin xác thực không khớp: ' . implode(',', $invalidFields))->withInput();
            }

            // ✅ Lưu vào session
            $id = $surveyId;
            session()->put("verified_{$id}", true);
            session()->put("student_code_{$id}", $student->code);
            session()->put("email_{$id}", $student->email);

            return redirect()->route('admin.contact-survey.form', ['id' => $id]);

            return response()->json([
                'success' => true,
                'student' => $student,
            ]);
        } catch (\Exception $e) {
            Log::error($e);
            return redirect()->back()->withInput()->with('error', 'Không tìm thấy sinh viên có mã này trong khảo sát');
        }
    }

    public function submit(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'survey_id' => 'required|exists:survey,id',
            ], [], [
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $recruitmentValue = json_encode(['value' => $request->input('recruitment_type', []), 'content_other' => request('recruitment_type_other')]);
            $soft_skills_required = json_encode(['value' => $request->input('soft_skills_required', []), 'content_other' => request('soft_skills_required_other')]);
            $must_attended_courses = json_encode(['value' => $request->input('must_attended_courses', []), 'content_other' => request('must_attended_courses_other')]);
            $solutions_get_job = json_encode(['value' => $request->input('solutions_get_job', []), 'content_other' => request('solutions_get_job_other')]);
            $job_search_method = json_encode(['value' => $request->input('job_search_method', []), 'content_other' => request('job_search_method_other')]);

            EmploymentSurveyResponse::updateOrCreate([
                'survey_period_id' => request('survey_id'),
                'student_id' => request('student_id'),
                'code_student' => request('code_student'),
            ], [
                'full_name' => request('full_name'),
                'email' => request('email'),
                'gender' => request('gender'),
                'dob' => request('dob'),
                'identification_card_number' => request('identification_card_number'),
                'identification_issuance_place' => request('identification_issuance_place'),
                'identification_issuance_date' => request('identification_issuance_date'),
                'training_industry_id' => request('training_industry_id'),
                'phone_number' => request('phone_number'),
                'course' => request('course'),
                'employment_status' => request('employment_status'),
                'recruit_partner_name' => request('recruit_partner_name'),
                'recruit_partner_address' => request('recruit_partner_address'),
                'recruit_partner_date' => request('recruit_partner_date'),
                'recruit_partner_position' => request('recruit_partner_position'),
                'work_area' => request('work_area'),
                'employed_since' => request('employed_since'),
                'trained_field' => request('trained_field'),
                'professional_qualification_field' => request('professional_qualification_field'),
                'level_knowledge_acquired' => request('level_knowledge_acquired'),
                'starting_salary' => request('starting_salary'),
                'average_income' => request('average_income'),
                'recruitment_type' => $recruitmentValue,
                'soft_skills_required' => $soft_skills_required,
                'must_attended_courses' => $must_attended_courses,
                'solutions_get_job' => $solutions_get_job,
                'job_search_method' => $job_search_method,
            ]);

            return redirect()->route('survey.thankyou')->with('success', 'Ghi nhận khảo sát thành công!');
        } catch (\Exception $e) {
            Log::error($e);
            return redirect()->back()->with('error', 'System error');
        }
    }

    public function sendMail($id)
    {
        try {
            // @todo get all student by survey
            // send mail to all
        } catch (\Exception $e) {
            Log::error($e);
        }
    }
}
