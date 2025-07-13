<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactSurveyBatch;
use App\Models\AlumniContact;

class ContactSurveyController extends Controller
{
    // Danh sách các đợt khảo sát
    public function index()
    {
        $batches = ContactSurveyBatch::withCount('alumniContacts')->latest()->get();
        return view('admin.pages.admin.alumni-info-form.index', compact('batches'));
    }

    // Tạo mới đợt khảo sát
    public function create()
    {
        return view('admin.pages.admin.alumni-info-form.create-form');
    }

    // Lưu đợt khảo sát
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after_or_equal:start_time',
        ]);

        ContactSurveyBatch::create($request->only(['title', 'description', 'start_time', 'end_time']));
        return redirect()->route('admin.survey.index')->with('success', 'Tạo đợt khảo sát thành công!');
    }

    // Sửa đợt khảo sát
    public function edit($id)
    {
        $batch = ContactSurveyBatch::findOrFail($id);
        return view('admin.pages.admin.alumni-info-form.edit-form', compact('batch'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after_or_equal:start_time',
        ]);

        $batch = ContactSurveyBatch::findOrFail($id);
        $batch->update($request->only(['title', 'description', 'start_time', 'end_time']));

        return redirect()->route('admin.survey.index')->with('success', 'Cập nhật thành công!');
    }

    public function destroy($id)
    {
        $batch = ContactSurveyBatch::findOrFail($id);
        $batch->delete();
        return back()->with('success', 'Xóa đợt khảo sát thành công!');
    }

    // Form cho sinh viên điền
    public function showForm($id)
    {
        $batch = ContactSurveyBatch::findOrFail($id);
        return view('client.survey.form', compact('batch'));
    }

    // Lưu kết quả điền form
    public function submitForm(Request $request, $id)
    {
        $request->validate([
            'student_code' => 'required',
            'full_name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
        ]);

        AlumniContact::create(array_merge(
            $request->only([
                'student_code', 'full_name', 'gender', 'date_of_birth', 'place_of_birth',
                'address', 'phone', 'email', 'facebook', 'instagram',
                'company_name', 'company_address', 'company_phone', 'company_email'
            ]),
            ['survey_batch_id' => $id]
        ));

        return redirect()->route('alumni-thankyou')->with('success', 'Cảm ơn bạn đã hoàn thành khảo sát!');
    }

    // Xem kết quả khảo sát theo đợt
    public function viewResults($id)
    {
        $batch = ContactSurveyBatch::with('alumniContacts')->findOrFail($id);
        return view('admin.pages.admin.alumni-info-form.results', compact('batch'));
    }
}
