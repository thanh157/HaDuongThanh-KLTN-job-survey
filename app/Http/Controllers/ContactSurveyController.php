<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\ContactSurvey; // ✅ Dùng model mới
use App\Models\Graduation;
use App\Models\AlumniContact;

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

    public function handleVerify(Request $request, $id)
    {
        $survey = ContactSurvey::findOrFail($id);

        $request->validate([
            'student_code' => 'required|string',
            'email' => 'required|email',
        ]);

        return redirect()->route('survey.form', ['id' => $survey->id])
            ->with('verified', true)
            ->withInput($request->only(['student_code', 'email']));
    }

    public function showForm($id)
    {
        $survey = ContactSurvey::with('graduations.students')->findOrFail($id);

        $students = $survey->graduations->flatMap(function ($graduation) {
            return $graduation->students;
        });

        $studentCode = session()->getOldInput('student_code');
        $email = session()->getOldInput('email');

        return view('admin.pages.admin.alumni-info-form.form', compact('survey', 'students', 'studentCode', 'email'));
    }

    public function submitForm(Request $request, $id)
    {
        $request->validate([
            'student_code' => 'required',
            'class_code' => 'required',
            'full_name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'address' => 'required',
        ]);

        AlumniContact::create([
            'student_code' => $request->student_code,
            'class_code' => $request->class_code,
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
            'survey_batch_id' => $id,
        ]);

        return redirect()->route('alumni-thankyou')->with('success', 'Cảm ơn bạn đã hoàn thành khảo sát!');
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
}
