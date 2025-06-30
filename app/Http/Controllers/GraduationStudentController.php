<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class GraduationStudentController extends Controller
{
    public function index($graduationId)
    {
        $path = base_path('app/JSON/GraduationStudents.json');
        $students = File::exists($path) ? json_decode(File::get($path), true) : [];

        // Lọc theo đợt tốt nghiệp
        $filtered = collect($students)->where('graduation_id', (int) $graduationId)->values();

        return view('admin.pages.admin.graduation-student-index', [
            'students' => $filtered,
            'graduationId' => $graduationId,
        ]);
    }

    public function create($graduationId)
    {
        return view('admin.pages.admin.graduation-student-create', compact('graduationId'));
    }

    public function store(Request $request, $graduationId)
    {
        $request->validate([
            'ma_sv' => 'required|string',
            'ho_ten' => 'required|string',
            'lop' => 'required|string',
            'nganh' => 'required|string',
            'email' => 'nullable|email',
            'sdt' => 'nullable|string',
        ]);

        $path = base_path('app/JSON/GraduationStudents.json');
        $students = File::exists($path) ? json_decode(File::get($path), true) : [];

        $newId = collect($students)->max('id') + 1;

        $data = [
            'id' => $newId,
            'graduation_id' => (int) $graduationId,
            'ma_sv' => $request->ma_sv,
            'ho_ten' => $request->ho_ten,
            'lop' => $request->lop,
            'nganh' => $request->nganh,
            'email' => $request->email,
            'sdt' => $request->sdt,
            'created_at' => now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s'),
        ];

        $students[] = $data;

        File::put($path, json_encode($students, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        return redirect()->route('admin.graduation-student.index', $graduationId)
            ->with('success', 'Đã thêm sinh viên tốt nghiệp!');
    }
}
