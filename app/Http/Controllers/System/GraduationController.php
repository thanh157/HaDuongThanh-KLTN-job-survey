<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\DotTotnghiep;
use App\Models\DotTotNghiepStudent;
use App\Models\GraduationStudent;
use App\Models\Student;
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

        // dd($response['data']);

        // $allStudents = collect($response['data'])
        //     ->flatMap(function ($item) {
        //         return collect($item['students'])->map(function ($student) use ($item) {
        //             // Gộp school_year vào từng sinh viên
        //             $student['school_year'] = $item['school_year'];
        //             return $student;
        //         });
        //     })
        //     ->toArray();

        // dd($allStudents);


        $graduations = collect($response['data'] ?? []);
        // dd($graduations);

        foreach ($graduations as $item) {
            Graduation::query()->updateOrCreate(
                [
                    'id' => data_get($item, 'id')
                ],
                [
                    'name' => data_get($item, 'name'),
                    'school_year' => data_get($item, 'school_year'),
                    'certification' => data_get($item, 'certification'),
                    'certification_date' => Carbon::parse(data_get($item, 'certification_date'))->toDateString(),
                    'faculty_id' => data_get($item, 'faculty_id'),
                    'student_count' => data_get($item, 'student_count'),
                    'created_at' => Carbon::parse(data_get($item, 'created_at')),
                    'updated_at' => Carbon::parse(data_get($item, 'updated_at')),
                ]
            );

            $students = data_get($item, 'students', []);

            if (count($students) > 0) {
                GraduationStudent::query()->where('graduation_id', data_get($item, 'id'))->delete();
            }
            foreach ($students as $item2) {
                Student::query()->updateOrCreate(
                    [
                        'id' => data_get($item2, 'id'),
                        'code' => data_get($item2, 'code'),
                        'email' => data_get($item2, 'email'),
                    ],
                    [
                        'last_name' => data_get($item2, 'last_name'),
                        'first_name' => data_get($item2, 'first_name'),
                        'full_name' => data_get($item2, 'full_name'),
                        'training_industry_id' => data_get($item2, 'training_industry_id'),
                        'dob' => data_get($item2, 'dob'),
                        'citizen_identification' => data_get($item2, 'citizen_identification'),
                        'phone' => data_get($item2, 'phone'),
                        'gender' => data_get($item2, 'gender'),
                        'created_at' => Carbon::parse(data_get($item2, 'created_at')),
                        'updated_at' => Carbon::parse(data_get($item2, 'updated_at')),
                    ]
                );
                GraduationStudent::create([
                    'student_id' => data_get($item2, 'id'),
                    'graduation_id' => data_get($item, 'id'),
                ]);
            }
        }


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

        // Chỉ hiển thị nếu tổng số > $perPage
        $showPaginationInfo = $graduations->count() > $perPage;

        return view('admin.pages.admin.graduation', [
            'graduations' => $graduationsPaginated,
            'showPaginationInfo' => $showPaginationInfo,
        ]);
    }


    public function showStudents(Request $request, $graduationId)
    {
        $graduation = Graduation::with('students')->findOrFail($graduationId);

        $studentsQuery = Student::whereHas('graduations', function ($q) use ($graduationId) {
            $q->where('graduation_id', $graduationId);
        });

        // Lọc theo mã sinh viên
        if ($request->filled('code')) {
            $studentsQuery->where('code', 'like', '%' . $request->input('code') . '%');
        }

        // Lọc theo họ tên
        if ($request->filled('name')) {
            $studentsQuery->where('full_name', 'like', '%' . $request->input('name') . '%');
        }

        // Lọc theo email
        if ($request->filled('email')) {
            $studentsQuery->where('email', 'like', '%' . $request->input('email') . '%');
        }

        $allStudents = $studentsQuery->orderBy('created_at', 'desc')->get();

        // Phân trang thủ công
        $perPage = 10;
        $currentPage = $request->get('page', 1);
        $paged = $allStudents->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $students = new \Illuminate\Pagination\LengthAwarePaginator(
            $paged,
            $allStudents->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        $showPaginationInfo = $allStudents->count() > $perPage;

        return view('admin.pages.admin.graduation-students', [
            'students' => $students,
            'graduation' => $graduation,
            'showPaginationInfo' => $showPaginationInfo,
        ]);
    }

    // public function create()
    // {
    //     return view('admin.pages.admin.graduation-create');
    // }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'dot_tot_nghiep' => 'required|string',
    //         'nam_tot_nghiep' => 'required|string',
    //         'tong_sinh_vien' => 'required|numeric',
    //     ]);

    //     $path = base_path('app/JSON/Graduation.json');
    //     $graduations = File::exists($path) ? json_decode(File::get($path), true) : [];

    //     $newId = collect($graduations)->max('id') + 1;

    //     $data = [
    //         'id' => $newId,
    //         'dot_tot_nghiep' => $request->dot_tot_nghiep,
    //         'nam_tot_nghiep' => $request->nam_tot_nghiep,
    //         'tong_sinh_vien' => $request->tong_sinh_vien,
    //         'created_at' => now()->format('Y-m-d H:i:s'), // đảm bảo giờ đúng
    //     ];

    //     $graduations[] = $data;

    //     File::put($path, json_encode($graduations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

    //     return redirect()->route('admin.graduation.index')->with('success', 'Thêm đợt tốt nghiệp thành công!');
    // }

    // public function edit($id)
    // {
    //     $path = base_path('app/JSON/Graduation.json');
    //     $graduations = File::exists($path) ? json_decode(File::get($path), true) : [];

    //     $item = collect($graduations)->firstWhere('id', (int) $id);
    //     if (!$item) return redirect()->route('admin.graduation.index')->with('error', 'Không tìm thấy đợt tốt nghiệp.');

    //     return view('admin.pages.admin.graduation-edit', compact('item'));
    // }

    // public function destroy($id)
    // {
    //     $path = base_path('app/JSON/Graduation.json');
    //     $graduations = File::exists($path) ? json_decode(File::get($path), true) : [];

    //     $graduations = array_filter($graduations, fn($item) => $item['id'] != $id);
    //     File::put($path, json_encode(array_values($graduations), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

    //     return redirect()->route('admin.graduation.index')->with('success', 'Đã xoá đợt tốt nghiệp.');
    // }


    // public function update(Request $request, $id)
    // {
    //     $request->validate([
    //         'dot_tot_nghiep' => 'required|string',
    //         'nam_tot_nghiep' => 'required|string',
    //         'tong_sinh_vien' => 'required|numeric',
    //     ]);

    //     $path = base_path('app/JSON/Graduation.json');
    //     $graduations = File::exists($path) ? json_decode(File::get($path), true) : [];

    //     foreach ($graduations as &$item) {
    //         if ($item['id'] == $id) {
    //             $item['dot_tot_nghiep'] = $request->input('dot_tot_nghiep');
    //             $item['nam_tot_nghiep'] = $request->input('nam_tot_nghiep');
    //             $item['tong_sinh_vien'] = $request->input('tong_sinh_vien');
    //             $item['updated_at'] = now()->format('Y-m-d H:i:s');
    //             break;
    //         }
    //     }

    //     File::put($path, json_encode($graduations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

    //     return redirect()->route('admin.graduation.index')->with('success', 'Sửa đợt tốt nghiệp thành công!');
    // }
}
