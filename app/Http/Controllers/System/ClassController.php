<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Services\StudentService;
use Illuminate\Support\Str;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ClassController extends Controller
{
    protected $studentService;

    public function __construct(StudentService $studentService)
    {
        $this->studentService = $studentService;
    }

    public function index(Request $request)
    {
        $facultyId = $this->studentService->getFacultyId(); // ví dụ trả về 1
        $search = $request->query('search');

        // Lấy token
        $token = cache()->remember('token_client1', 60 * 5, function () {
            return $this->studentService->post('/oauth/token', [
                'grant_type' => 'client_credentials',
                'client_id' => config('auth.student.client_id'),
                'client_secret' => config('auth.student.client_secret'),
            ]);
        });

        // Lấy dữ liệu lớp học từ API
        $classes = $this->studentService->get("/api/v1/external/classes/faculty/{$facultyId}", [
            'access_token' => Arr::get($token, 'access_token'),
        ]);

        $grouped = [];

        foreach ($classes['data'] ?? [] as $class) {
            $khoa = strtoupper(substr($class['code'], 0, 3)); // K69, K68...
            if ($search && stripos($khoa, $search) === false) continue;

            if (!isset($grouped[$khoa])) {
                $grouped[$khoa] = [
                    'khoa' => $khoa,
                    'nam' => '20' . substr($khoa, 1, 2), // ví dụ K69 => 2069
                    'tong_so_lop' => 0,
                    'nhap_hoc' => 0,
                    'hien_tai' => 0,
                    'id' => $khoa, // dùng tạm cho route
                ];
            }

            $grouped[$khoa]['tong_so_lop']++;
            $grouped[$khoa]['nhap_hoc'] += 0; // thêm nếu có dữ liệu
            $grouped[$khoa]['hien_tai'] += 0; // thêm nếu có dữ liệu
        }

        return view('admin.pages.admin.class', [
            'classes' => array_values($grouped),
        ]);
    }

    public function showByKhoa(Request $request, $khoa)
    {
        $token = cache()->remember('token_client1', 300, function () {
            return $this->studentService->post('/oauth/token', [
                'grant_type' => 'client_credentials',
                'client_id' => config('auth.student.client_id'),
                'client_secret' => config('auth.student.client_secret'),
            ]);
        });

        $facultyId = $this->studentService->getFacultyId();

        // Lấy danh sách lớp của khoa
        $classes = $this->studentService->get("/api/v1/external/classes/faculty/{$facultyId}", [
            'access_token' => Arr::get($token, 'access_token'),
        ]);

        // Lọc theo khóa học (K69, K68...)
        $filtered = collect($classes['data'] ?? [])->filter(function ($class) use ($khoa) {
            return Str::startsWith($class['code'], $khoa);
        })->values();

        // Tìm kiếm
        $search = $request->query('search');
        if ($search) {
            $filtered = $filtered->filter(function ($class) use ($search) {
                return stripos($class['code'], $search) !== false ||
                    stripos($class['description'], $search) !== false;
            })->values();
        }

        // Thêm số lượng sinh viên cho mỗi lớp
        foreach ($filtered as &$class) {
            $classCode = $class['code'];

            // Gọi API sinh viên theo lớp
            $studentResponse = $this->studentService->get("/api/v1/external/students/class/{$classCode}", [
                'access_token' => Arr::get($token, 'access_token'),
            ]);

            $students = collect($studentResponse['data'] ?? []);
            $class['student_count'] = $students->count(); // Gắn sĩ số
        }

        // Phân trang
        $perPage = 6;
        $currentPage = $request->get('page', 1);
        $paged = $filtered->slice(($currentPage - 1) * $perPage, $perPage)->values();
        $classesPaginated = new \Illuminate\Pagination\LengthAwarePaginator(
            $paged,
            $filtered->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('admin.pages.admin.class-by-khoa', [
            'khoa' => $khoa,
            'classes' => $classesPaginated,
        ]);
    }


    public function showStudents(Request $request, $code)
    {
        $token = cache()->remember('token_client1', 300, function () {
            return $this->studentService->post('/oauth/token', [
                'grant_type' => 'client_credentials',
                'client_id' => config('auth.student.client_id'),
                'client_secret' => config('auth.student.client_secret'),
            ]);
        });

        $facultyId = $this->studentService->getFacultyId();

        // Gọi API để lấy toàn bộ sinh viên của lớp
        $response = $this->studentService->get("/api/v1/external/students/faculty/{$facultyId}?q={$code}", [
            'access_token' => Arr::get($token, 'access_token'),
        ]);

        // Lấy query filter
        $filterCode = $request->query('code');
        $filterName = $request->query('name');
        $filterEmail = $request->query('email');

        // Không lọc theo startsWith($student['code'], $code) nữa
        $students = collect($response['data'] ?? [])->filter(function ($student) use ($filterCode, $filterName, $filterEmail) {
            return (!$filterCode || Str::contains($student['code'], $filterCode))
                && (!$filterName || Str::contains(Str::lower($student['full_name']), Str::lower($filterName)))
                && (!$filterEmail || Str::contains(Str::lower($student['email']), Str::lower($filterEmail)));
        })->values();

        // Phân trang
        $perPage = 10;
        $currentPage = $request->get('page', 1);
        $paged = $students->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $studentsPaginated = new \Illuminate\Pagination\LengthAwarePaginator(
            $paged,
            $students->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('admin.pages.admin.students-by-class', [
            'students' => $studentsPaginated,
            'classCode' => $code,
        ]);
    }
}
