<?php

namespace App\Http\Controllers;

use App\Models\EmploymentSurveyResponse;
use App\Models\Major;
use App\Models\Survey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\ContactSurvey; // ✅ Dùng model mới
use App\Models\Graduation;
use App\Models\AlumniContact;
use Carbon\Carbon;
use App\Models\Student;

class ContactSurveyController extends Controller
{
    public function index()
    {
        $batches = ContactSurvey::with(['graduations:id,school_year,student_count', 'alumniContacts'])->latest()->paginate(10);

        foreach ($batches as $batch) {
            $batch->responses_count = $batch->alumni_contacts_count ?? 0;
            $batch->total_students = $batch->graduations->sum('student_count');
        }

        $allYears = Graduation::whereHas('contactSurveys')->pluck('school_year')->unique();

        return view('admin.pages.admin.alumni-info-form.index', compact('batches', 'allYears'));
    }

    public function create()
    {
        $namTotNghiep = Graduation::select('school_year')->groupBy('school_year')->pluck('school_year')->toArray();
        return view('admin.pages.admin.alumni-info-form.create-form', compact('namTotNghiep'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'graduation_id' => 'required|array|min:1',
                'start_time' => 'required|date',
                'end_time' => 'bail|required|date|after_or_equal:start_time|after:now',
            ], [
                'title.required' => 'Vui lòng nhập tiêu đề.',
                'graduation_id.required' => 'Vui lòng chọn ít nhất một đợt tốt nghiệp.',
                'end_time.after_or_equal' => 'Thời gian kết thúc không được trước thời gian bắt đầu.',
                'end_time.after' => 'Thời gian kết thúc phải lớn hơn hiện tại.',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $survey = ContactSurvey::create([
                'title' => $request->title,
                'description' => $request->description,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'status' => ContactSurvey::STATUS_ACTIVE
            ]);

            $survey->graduations()->attach($request->graduation_id);

            DB::commit();
            return redirect()->route('admin.contact-survey.index')->with('success', 'Tạo khảo sát thành công!');
        } catch (\Exception $e) {
            Log::error($e);
            DB::rollBack();
            return redirect()->route('admin.contact-survey.index')->with('error', 'Lỗi hệ thống khi tạo khảo sát.');
        }
    }

    public function edit($id)
    {
        $survey = ContactSurvey::with('graduations')->findOrFail($id);

        // ✅ Lấy danh sách năm tốt nghiệp duy nhất
        $namTotNghiep = Graduation::select('school_year')->distinct()->orderBy('school_year', 'desc')->pluck('school_year');

        // ✅ Lấy tất cả đợt tốt nghiệp để hiển thị ban đầu
        $allDotTotNghiep = Graduation::orderBy('school_year', 'desc')->get();

        // ✅ Lấy các ID đợt tốt nghiệp đã được chọn
        $selectedGraduationIds = $survey->graduations->pluck('id')->toArray();

        return view('admin.pages.admin.alumni-info-form.edit-form', compact(
            'survey',
            'namTotNghiep',
            'allDotTotNghiep',
            'selectedGraduationIds'
        ));
    }


    public function update(Request $request, $id)
    {
        $survey = ContactSurvey::with('graduations')->findOrFail($id);

        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after_or_equal:start_time',
            'status' => 'required|in:0,1',
        ];

        if ($request->status == ContactSurvey::STATUS_ACTIVE) {
            $rules['graduation_id'] = 'array|min:1';
        }

        $validated = $request->validate($rules);

        $survey->update([
            'title' => $request->title,
            'description' => $request->description,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'status' => $request->status,
        ]);

        if ($request->status == ContactSurvey::STATUS_ACTIVE) {
            $graduationIds = $request->graduation_id ?? $survey->graduations->pluck('id')->toArray();
            $survey->graduations()->sync($graduationIds);
        }

        return redirect()->route('admin.contact-survey.index')->with('success', 'Cập nhật khảo sát thành công!');
    }

    public function destroy($id)
    {
        $survey = ContactSurvey::findOrFail($id);
        $survey->graduations()->detach();
        $survey->delete();

        return back()->with('success', 'Xoá đợt khảo sát thành công!');
    }

    public function verifyForm($id)
    {
        $survey = ContactSurvey::findOrFail($id);
        return view('admin.contact-survey.authenticate', compact('survey'));
    }

    // public function handleVerify(Request $request, $id)
    // {
    //     $survey = ContactSurvey::findOrFail($id);

    //     $request->validate([
    //         'student_code' => 'required|string',
    //         'email' => 'required|email',
    //     ]);

    //     return redirect()->route('survey.form', ['id' => $survey->id])
    //         ->with('verified', true)
    //         ->withInput($request->only(['student_code', 'email']));
    // }

    public function showForm($id)
    {
        $survey = ContactSurvey::with([
            'graduations.students.trainingIndustry'
        ])->findOrFail($id);

        $students = $survey->graduations->flatMap(function ($graduation) {
            return $graduation->students;
        });

        // Nếu chưa xác thực → hiện form xác thực
        if (!session()->get("verified_{$id}")) {
            return view('admin.pages.admin.alumni-info-form.authenticate', compact('survey'));
        }

        $studentCode = session()->get("student_code_{$id}");
        $student = Student::where('code', $studentCode)->first();
        if (empty($student)) {
            Log::error("Not found student with code $studentCode");
            abort(404);
        }
        $email = session()->get("email_{$id}");

        return view('admin.pages.admin.alumni-info-form.form', compact('student', 'survey', 'students', 'studentCode', 'email'));
    }

    public function handleVerify(Request $request, $id)
    {
        $request->validate([
            'student_code' => 'nullable|string',
            'full_name' => 'nullable|string',
            'email' => 'nullable|email',
            'date_of_birth' => 'nullable|date',
            'training_industry' => 'nullable|string',
            'school_year_end' => 'nullable|string',
        ]);

        $survey = ContactSurvey::with('graduations')->findOrFail($id);

        // Lấy danh sách các năm tốt nghiệp của khảo sát này
        $validSchoolYears = $survey->graduations->pluck('school_year')->toArray();

        // Lọc danh sách sinh viên theo năm tốt nghiệp
        $students = Student::whereIn('school_year_end', $validSchoolYears)->get();

        // So khớp sinh viên theo điều kiện xác thực
        $match = $students->first(function ($student) use ($request) {
            $matched = 0;

            if ($request->student_code && $student->code == $request->student_code) {
                $matched++;
            }

            if ($request->full_name && strcasecmp(trim($student->full_name), trim($request->full_name)) == 0) {
                $matched++;
            }

            if ($request->email && strtolower($student->email) == strtolower($request->email)) {
                $matched++;
            }

            if ($request->date_of_birth && $student->dob) {
                try {
                    if (Carbon::parse($student->dob)->toDateString() === Carbon::parse($request->date_of_birth)->toDateString()) {
                        $matched++;
                    }
                } catch (\Exception $e) {
                    // ignore parsing error
                }
            }

            if ($request->training_industry && $student->trainingIndustry && strcasecmp($student->trainingIndustry->name, $request->training_industry) == 0) {
                $matched++;
            }

            if ($request->school_year_end && $student->school_year_end == $request->school_year_end) {
                $matched++;
            }

            // Chấp nhận nếu có ít nhất 2 thông tin khớp
            return $matched >= 2;
        });

        if (!$match) {
            return back()->withErrors(['Xác thực không thành công. Vui lòng kiểm tra lại thông tin.'])->withInput();
        }

        // ✅ Lưu vào session
        session()->put("verified_{$id}", true);
        session()->put("student_code_{$id}", $match->code);
        session()->put("email_{$id}", $match->email);

        return redirect()->route('admin.contact-survey.form', ['id' => $id]);
    }

    public function submitForm(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'student_code' => 'required',
            'course' => 'required',
            'full_name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'address' => 'required',
        ], [], [
            'course' => 'Khóa học',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        AlumniContact::updateOrCreate([
            'survey_batch_id' => $id,
            'student_code' => request('student_code'),
        ], [
            'course' => $request->course,
            'full_name' => $request->full_name,
            'gender' => $request->gender,
            'date_of_birth' => $request->date_of_birth,
            'place_of_birth' => $request->place_of_birth,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'facebook' => $request->facebook,
            'instagram' => $request->instagram,
            'company_name' => $request->company_name,
            'company_address' => $request->company_address,
            'company_phone' => $request->company_phone,
            'company_email' => $request->company_email,
        ]);

        session()->forget("verified_{$id}");

        return redirect()->route('contact-survey.thankyou')->with('success', 'Cảm ơn bạn đã hoàn thành khảo sát!');
    }

    public function getGraduationCeremonies(Request $request)
    {
        $years = $request->input('years', []);

        if (empty($years)) {
            return response()->json([]);
        }

        $data = Graduation::whereIn('school_year', $years)->get(['id', 'name', 'school_year']);
        return response()->json($data);
    }

    public function surveyResults($id)
    {
        $survey = ContactSurvey::findOrFail($id);
        $results = AlumniContact::where('survey_batch_id', $id)->get();

        return view('admin.pages.admin.alumni-info-form.results', compact('survey', 'results'));
    }

    /**
     * @param $id: contact_surveys.id
     * @return \Illuminate\Container\Container|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|mixed|object
     */
    public function viewResults($id, Request $request)
    {
        $survey = ContactSurvey::with('graduations.students')->findOrFail($id);

        // Lấy danh sách các mã sinh viên liên quan đến khảo sát này
        $graduationStudentIds = $survey->graduations->flatMap(function ($graduation) {
            return $graduation->students->pluck('code');
        });

        $query = AlumniContact::where('survey_batch_id', $id);

        // Tìm kiếm theo tên hoặc mã SV
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('student_code', 'like', '%' . $search . '%')
                    ->orWhere('full_name', 'like', '%' . $search . '%');
            });
        }

        // Tổng số SV được khảo sát (dựa trên liên kết đợt tốt nghiệp)
        $totalStudents = $graduationStudentIds->unique()->count();

        // Tổng số phản hồi
        $count = AlumniContact::where('survey_batch_id', $id)->count();

        $results = $query->paginate(10)->withQueryString();

        return view('admin.pages.admin.alumni-info-form.results', [
            'survey' => $survey,
            'results' => $results,
            'count' => $count,
            'totalStudents' => $totalStudents,
        ]);
    }

    public function thankyou()
    {
        return view('admin.pages.admin.alumni-info-form.thankyou');
    }

    /**
     * @param $id
     * employment_survey_responses_v2.id
     */
    public function showStudentSubmit($id)
    {
        $res = EmploymentSurveyResponse::where('id', $id)->first();
        if (empty($res)) {
            return abort(404);
        }

        $student = Student::where('id', $res->student_id)->first();
        $survey = Survey::where('id', $res->survey_period_id)->first();

        if (empty($survey) || empty($student)) {
            return abort(404);
        }

        $major = Major::query()->pluck('name', 'id')->toArray();

        $viewData = [
            'survey' => $survey,
            'response' => $res,
            'student' => $student,
            'major' => $major,
        ];

        return view('admin.pages.admin.survey.result_show', $viewData);
    }
}
