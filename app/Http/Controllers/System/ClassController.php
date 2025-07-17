<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Services\StudentService;
use Illuminate\Pagination\LengthAwarePaginator;

class ClassController extends Controller
{
    protected $studentService;

    public function __construct(StudentService $studentService)
    {
        $this->studentService = $studentService;
    }

    // Trang danh sách các khóa
    public function index(Request $request)
    {
        $facultyId = $this->studentService->getFacultyId();
        $search = $request->query('search');

        $token = cache()->remember('token_client1', 300, function () {
            return $this->studentService->post('/oauth/token', [
                'grant_type' => 'client_credentials',
                'client_id' => config('auth.student.client_id'),
                'client_secret' => config('auth.student.client_secret'),
            ]);
        });

        $classes = $this->studentService->get("/api/v1/external/classes/faculty/{$facultyId}", [
            'access_token' => Arr::get($token, 'access_token'),
        ]);

        $grouped = [];

        foreach ($classes['data'] ?? [] as $class) {
            $khoa = strtoupper(substr($class['code'], 0, 3));
            if ($search && stripos($khoa, $search) === false) continue;

            if (!isset($grouped[$khoa])) {
                $grouped[$khoa] = [
                    'khoa' => $khoa,
                    'nam' => '20' . substr($khoa, 1, 2),
                    'tong_so_lop' => 0,
                    'nhap_hoc' => 0,
                    'hien_tai' => 0,
                    'id' => $khoa,
                ];
            }

            $grouped[$khoa]['tong_so_lop']++;
        }

        return view('admin.pages.admin.class.class', [
            'classes' => array_values($grouped),
        ]);
    }

    // Trang danh sách lớp theo khóa
    public function showByKhoa(Request $request, $khoa)
    {
        $facultyId = $this->studentService->getFacultyId();

        $token = cache()->remember('token_client1', 300, function () {
            return $this->studentService->post('/oauth/token', [
                'grant_type' => 'client_credentials',
                'client_id' => config('auth.student.client_id'),
                'client_secret' => config('auth.student.client_secret'),
            ]);
        });

        $classes = $this->studentService->get("/api/v1/external/classes/faculty/{$facultyId}", [
            'access_token' => Arr::get($token, 'access_token'),
        ]);

        $filtered = collect($classes['data'] ?? [])->filter(function ($class) use ($khoa) {
            return Str::startsWith($class['code'], $khoa);
        })->values();

        $search = $request->query('search');
        if ($search) {
            $filtered = $filtered->filter(function ($class) use ($search) {
                return stripos($class['code'], $search) !== false ||
                    stripos($class['description'], $search) !== false;
            })->values();
        }

        foreach ($filtered as &$class) {
            $classCode = $class['code'];
            $studentResponse = $this->studentService->get("/api/v1/external/students/class/{$classCode}", [
                'access_token' => Arr::get($token, 'access_token'),
            ]);
            $class['student_count'] = count($studentResponse['data'] ?? []);
        
        }

        $perPage = 6;
        $currentPage = $request->get('page', 1);
        $paged = $filtered->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $classesPaginated = new LengthAwarePaginator(
            $paged,
            $filtered->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('admin.pages.admin.class.class-by-khoa', [
            'khoa' => $khoa,
            'classes' => $classesPaginated,
        ]);
    }

    // Trang danh sách sinh viên trong lớp
    public function showStudents(Request $request, $code)
    {
        $facultyId = $this->studentService->getFacultyId();

        $token = cache()->remember('token_client1', 300, function () {
            return $this->studentService->post('/oauth/token', [
                'grant_type' => 'client_credentials',
                'client_id' => config('auth.student.client_id'),
                'client_secret' => config('auth.student.client_secret'),
            ]);
        });

        $response = $this->studentService->get("/api/v1/external/students/faculty/{$facultyId}?q={$code}", [
            'access_token' => Arr::get($token, 'access_token'),
        ]);

        $filterCode = $request->query('code');
        $filterName = $request->query('name');
        $filterEmail = $request->query('email');

        $students = collect($response['data'] ?? [])->filter(function ($student) use ($filterCode, $filterName, $filterEmail) {
            return (!$filterCode || Str::contains($student['code'], $filterCode)) &&
                (!$filterName || Str::contains(Str::lower($student['full_name']), Str::lower($filterName))) &&
                (!$filterEmail || Str::contains(Str::lower($student['email']), Str::lower($filterEmail)));
        })->values();

        $perPage = 10;
        $currentPage = $request->get('page', 1);
        $paged = $students->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $studentsPaginated = new LengthAwarePaginator(
            $paged,
            $students->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('admin.pages.admin.class.students-by-class', [
            'students' => $studentsPaginated,
            'classCode' => $code,
        ]);
    }

    // Trang chi tiết sinh viên (từ danh sách sinh viên theo lớp)
    public function showStudentDetail($id)
    {
        $token = cache()->remember('token_client1', 300, function () {
            return $this->studentService->post('/oauth/token', [
                'grant_type' => 'client_credentials',
                'client_id' => config('auth.student.client_id'),
                'client_secret' => config('auth.student.client_secret'),
            ]);
        });

        $facultyId = $this->studentService->getFacultyId();

        // Lấy thông tin sinh viên theo id
        $response = $this->studentService->get("/api/v1/external/students/faculty/{$facultyId}?q={$id}", [
            'access_token' => Arr::get($token, 'access_token'),
        ]);

        $student = collect($response['data'])->firstWhere('id', $id);

        if (!$student) {
            abort(404, 'Không tìm thấy sinh viên');
        }

        // Lấy mã lớp từ sinh viên (VD: CNTT67B)
        $classCode = $student['class'] ?? null;
        $classDetail = null;

        // Gọi API để lấy thông tin chi tiết lớp học đó
        if ($classCode) {
            $classListResponse = $this->studentService->get("/api/v1/external/classes/faculty/{$facultyId}?q={$classCode}", [
                'access_token' => Arr::get($token, 'access_token'),
            ]);

            $classDetail = collect($classListResponse['data'] ?? [])->firstWhere('code', $classCode);
        }

        return view('admin.pages.admin.class.student-class-detail', [
            'student' => $student,
            'class_code' => $classCode,
            'class_detail' => $classDetail,
        ]);
    }
}
