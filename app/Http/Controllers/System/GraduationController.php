<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\StudentService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use App\Models\Graduation;

class GraduationController extends Controller
{
    public function __construct(private StudentService $studentService) {}

    public function index(Request $request)
    {
        $facultyId = $this->studentService->getFacultyId();

        $token = cache()->remember(
            'token_client1',
            60 * 5,
            fn() =>
            $this->studentService->post('/oauth/token', [
                'grant_type' => 'client_credentials',
                'client_id' => config('auth.student.client_id'),
                'client_secret' => config('auth.student.client_secret'),
            ])
        );

        $response = $this->studentService->get('/api/v1/external/graduation-ceremonies/faculty/' . $facultyId, [
            'access_token' => Arr::get($token, 'access_token')
        ]);

        $graduations = collect($response['data'] ?? []);

        // Lọc theo tên
        if ($request->filled('name')) {
            $graduations = $graduations->filter(
                fn($item) =>
                str_contains(Str::lower($item['name']), Str::lower($request->input('name')))
            );
        }

        // Lọc theo năm
        if ($request->filled('year')) {
            $graduations = $graduations->filter(
                fn($item) =>
                str_contains(Str::lower($item['school_year']), Str::lower($request->input('year')))
            );
        }

        // Sắp xếp
        if ($request->input('sap_xep') === 'moi_nhat') {
            $graduations = $graduations->sortByDesc('created_at');
        } elseif ($request->input('sap_xep') === 'cu_nhat') {
            $graduations = $graduations->sortBy('created_at');
        }

        // Phân trang thủ công
        $perPage = 10;
        $currentPage = $request->get('page', 1);
        $paged = $graduations->slice(($currentPage - 1) * $perPage, $perPage)->values();
        $graduationsPaginated = new \Illuminate\Pagination\LengthAwarePaginator(
            $paged,
            $graduations->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('admin.pages.admin.graduation', [
            'graduations' => $graduationsPaginated
        ]);
    }


    public function showStudents(Request $request, $graduationId)
    {
        $facultyId = $this->studentService->getFacultyId();

        $token = cache()->remember('token_client1', 60 * 5, fn() => $this->studentService->post('/oauth/token', [
            'grant_type' => 'client_credentials',
            'client_id' => config('auth.student.client_id'),
            'client_secret' => config('auth.student.client_secret'),
        ]));

        $graduations = $this->studentService->get('/api/v1/external/graduation-ceremonies/faculty/' . $facultyId, [
            'access_token' => $token['access_token'],
        ]);

        $graduation = collect($graduations['data'])->firstWhere('id', (int) $graduationId);

        if (!$graduation) {
            return redirect()->route('admin.graduation.index')->with('error', 'Không tìm thấy đợt tốt nghiệp.');
        }

        // --- LỌC ---
        $students = collect($graduation['students'] ?? [])->filter(function ($student) use ($request) {
            if ($request->filled('name')) {
                $keyword = Str::lower(Str::ascii($request->input('name')));
                $studentName = Str::lower(Str::ascii($student['full_name']));
                if (!Str::contains($studentName, $keyword)) return false;
            }

            if ($request->filled('code') && !Str::contains($student['code'], $request->input('code'))) {
                return false;
            }

            if ($request->filled('email')) {
                $keyword = Str::lower(Str::ascii($request->input('email')));
                $studentEmail = Str::lower(Str::ascii($student['email']));
                if (!Str::contains($studentEmail, $keyword)) return false;
            }

            return true;
        });

        // --- SẮP XẾP ---
        if ($request->filled('sap_xep')) {
            $students = $students->sortBy(function ($student) {
                return Carbon::parse($student['created_at']);
            }, descending: $request->input('sap_xep') === 'moi_nhat');
        }

        // --- PHÂN TRANG ---
        $perPage = 10;
        $currentPage = request()->get('page', 1);
        $pagedStudents = $students->slice(($currentPage - 1) * $perPage, $perPage)->values();
        $studentsPaginated = new \Illuminate\Pagination\LengthAwarePaginator(
            $pagedStudents,
            $students->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('admin.pages.admin.graduation-students', [
            'students' => $studentsPaginated,
            'graduation' => $graduation,
        ]);
    }

    public function create()
    {
        return view('admin.pages.admin.graduation-create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'dot_tot_nghiep' => 'required|string',
            'nam_tot_nghiep' => 'required|string',
            'tong_sinh_vien' => 'required|numeric',
        ]);

        $path = base_path('app/JSON/Graduation.json');
        $graduations = File::exists($path) ? json_decode(File::get($path), true) : [];

        $newId = collect($graduations)->max('id') + 1;

        $data = [
            'id' => $newId,
            'dot_tot_nghiep' => $request->dot_tot_nghiep,
            'nam_tot_nghiep' => $request->nam_tot_nghiep,
            'tong_sinh_vien' => $request->tong_sinh_vien,
            'created_at' => now()->format('Y-m-d H:i:s'), // đảm bảo giờ đúng
        ];

        $graduations[] = $data;

        File::put($path, json_encode($graduations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        return redirect()->route('admin.graduation.index')->with('success', 'Thêm đợt tốt nghiệp thành công!');
    }

    public function edit($id)
    {
        $path = base_path('app/JSON/Graduation.json');
        $graduations = File::exists($path) ? json_decode(File::get($path), true) : [];

        $item = collect($graduations)->firstWhere('id', (int) $id);
        if (!$item) return redirect()->route('admin.graduation.index')->with('error', 'Không tìm thấy đợt tốt nghiệp.');

        return view('admin.pages.admin.graduation-edit', compact('item'));
    }

    public function destroy($id)
    {
        $path = base_path('app/JSON/Graduation.json');
        $graduations = File::exists($path) ? json_decode(File::get($path), true) : [];

        $graduations = array_filter($graduations, fn($item) => $item['id'] != $id);
        File::put($path, json_encode(array_values($graduations), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        return redirect()->route('admin.graduation.index')->with('success', 'Đã xoá đợt tốt nghiệp.');
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'dot_tot_nghiep' => 'required|string',
            'nam_tot_nghiep' => 'required|string',
            'tong_sinh_vien' => 'required|numeric',
        ]);

        $path = base_path('app/JSON/Graduation.json');
        $graduations = File::exists($path) ? json_decode(File::get($path), true) : [];

        foreach ($graduations as &$item) {
            if ($item['id'] == $id) {
                $item['dot_tot_nghiep'] = $request->input('dot_tot_nghiep');
                $item['nam_tot_nghiep'] = $request->input('nam_tot_nghiep');
                $item['tong_sinh_vien'] = $request->input('tong_sinh_vien');
                $item['updated_at'] = now()->format('Y-m-d H:i:s');
                break;
            }
        }

        File::put($path, json_encode($graduations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        return redirect()->route('admin.graduation.index')->with('success', 'Sửa đợt tốt nghiệp thành công!');
    }
}
