<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\AlumniContact;
use App\Models\ContactSurvey;
use App\Models\EmploymentSurveyResponse;
use App\Models\Major;
use App\Models\Student;
use App\Models\Survey;
use Illuminate\Http\Request;
use App\Services\StudentService;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Pagination\LengthAwarePaginator;
use Carbon\Carbon;

class StudentController extends Controller
{
    public function __construct(private StudentService $studentService) {}

    public function index(Request $request)
    {
        $facultyId = $this->studentService->getFacultyId();
        $token = cache()->remember('token_client1', 300, function () {
            return $this->studentService->post('/oauth/token', [
                'grant_type' => 'client_credentials',
                'client_id' => config('auth.student.client_id'),
                'client_secret' => config('auth.student.client_secret'),
            ]);
        });

        $response = $this->studentService->get("/api/v1/external/graduation-ceremonies/faculty/{$facultyId}", [
            'access_token' => Arr::get($token, 'access_token'),
        ]);

        $graduations = collect($response['data'] ?? []);

        $students = $graduations->flatMap(function ($graduation) {
            return collect($graduation['students'])->map(function ($student) use ($graduation) {
                $schoolYear = $graduation['school_year'];
                $graduatedYearsAgo = now()->year - (int) $schoolYear;

                return array_merge($student, [
                    'graduation_name' => $graduation['name'],
                    'school_year' => $schoolYear,
                    'certification' => $graduation['certification'],
                    'graduated_years_ago' => $graduatedYearsAgo
                ]);
            });
        });

        // ========== FILTER ==========
        if ($request->filled('code')) {
            $students = $students->filter(fn($s) => Str::contains(Str::lower($s['code']), Str::lower($request->input('code'))));
        }

        if ($request->filled('name')) {
            $students = $students->filter(fn($s) => Str::contains(Str::lower($s['full_name']), Str::lower($request->input('name'))));
        }

        if ($request->filled('email')) {
            $students = $students->filter(fn($s) => Str::contains(Str::lower($s['email']), Str::lower($request->input('email'))));
        }

        if ($request->filled('graduation_name')) {
            $students = $students->filter(fn($s) => Str::contains(Str::lower($s['graduation_name']), Str::lower($request->input('graduation_name'))));
        }

        if ($request->filled('school_year')) {
            $students = $students->filter(fn($s) => $s['school_year'] == $request->input('school_year'));
        }

        if ($request->filled('certification')) {
            $students = $students->filter(fn($s) => Str::contains(Str::lower($s['certification'] ?? ''), Str::lower($request->input('certification'))));
        }

        if ($request->filled('graduated_years_ago')) {
            $students = $students->filter(function ($s) use ($request) {
                return $s['graduated_years_ago'] == (int) $request->input('graduated_years_ago');
            });
        }

        // ========== PHÂN TRANG ==========
        $perPage = 10;
        $currentPage = $request->get('page', 1);
        $paged = $students->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $paginated = new LengthAwarePaginator(
            $paged,
            $students->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('admin.pages.admin.manage-student.student', [
            'allStudents' => $paginated
        ]);
    }

    public function show($id)
    {
        $facultyId = $this->studentService->getFacultyId();
        $token = cache()->remember('token_client1', 300, function () {
            return $this->studentService->post('/oauth/token', [
                'grant_type' => 'client_credentials',
                'client_id' => config('auth.student.client_id'),
                'client_secret' => config('auth.student.client_secret'),
            ]);
        });

        $response = $this->studentService->get("/api/v1/external/graduation-ceremonies/faculty/{$facultyId}", [
            'access_token' => Arr::get($token, 'access_token'),
        ]);

        $graduations = collect($response['data'] ?? []);

        // Tìm student theo ID và lấy graduation tương ứng
        foreach ($graduations as $graduation) {
            foreach ($graduation['students'] as $stu) {
                if ($stu['id'] == $id) {
                    $student = $stu;
                    $graduatedYearsAgo = now()->year - (int) $graduation['school_year'];

                    // Gộp thêm thông tin từ graduation vào student nếu muốn dùng gộp
                    $student = array_merge($student, [
                        'graduation_name' => $graduation['name'],
                        'school_year' => $graduation['school_year'],
                        'certification' => $graduation['certification'],
                        'certification_date' => $graduation['certification_date'],
                        'graduated_years_ago' => $graduatedYearsAgo,

                        // Thêm đầy đủ từ student
                        'first_name' => $student['first_name'] ?? null,
                        'last_name' => $student['last_name'] ?? null,
                        'email_edu' => $student['email_edu'] ?? null,
                        'training_type' => $student['training_type'] ?? null,
                        'permanent_residence' => $student['permanent_residence'] ?? null,
                        'pob' => $student['pob'] ?? null,
                        'countryside' => $student['countryside'] ?? null,
                        'note' => $student['note'] ?? null,
                        'created_at' => $student['created_at'] ?? null,
                        'updated_at' => $student['updated_at'] ?? null
                    ]);


                    return view('admin.pages.admin.manage-student.student-detail', [
                        'student' => $student,
                        'graduation' => $graduation
                    ]);
                }
            }
        }

        abort(404, 'Không tìm thấy sinh viên');
    }


    public function apiStudents(Request $request)
    {
        $facultyId = $this->studentService->getFacultyId();
        $token = cache()->remember('token_client1', 300, function () {
            return $this->studentService->post('/oauth/token', [
                'grant_type' => 'client_credentials',
                'client_id' => config('auth.student.client_id'),
                'client_secret' => config('auth.student.client_secret'),
            ]);
        });

        $response = $this->studentService->get("/api/v1/external/graduation-ceremonies/faculty/{$facultyId}", [
            'access_token' => Arr::get($token, 'access_token'),
        ]);

        $graduations = collect($response['data'] ?? []);

        $students = $graduations->flatMap(function ($graduation) {
            return collect($graduation['students'])->map(function ($student) use ($graduation) {
                $schoolYear = $graduation['school_year'];
                $graduatedYearsAgo = now()->year - (int) $schoolYear;

                return array_merge($student, [
                    'graduation_name' => $graduation['name'],
                    'school_year' => $schoolYear,
                    'certification' => $graduation['certification'],
                    'graduated_years_ago' => $graduatedYearsAgo
                ]);
            });
        });

        return response()->json([
            'data' => $students->values()
        ]);
    }

    public function listStudent()
    {
        $keyword = request('keyword');
        $student = Student::query()->with(['graduation']);
        if ($keyword) {
            $student->where('code', $keyword)->orWhere('full_name', 'like', "%$keyword%");
        }
        $student = $student->paginate(20);

        $viewData = [
            'student' => $student
        ];

        return view('admin.pages.admin.student-info', $viewData);
    }

    public function hopNhat($studentId, $surveyId)
    {
        $student = Student::where('id', $studentId)->first();
        $survey = ContactSurvey::where('id', $surveyId)->first();

        if (empty($survey) || empty($student)) {
            return abort(404);
        }

        $res = AlumniContact::where('survey_batch_id', $surveyId)->where('student_code', $student->code)->first();
        if (empty($res)) {
            return abort(404);
        }

        $major = Major::query()->pluck('name', 'id')->toArray();

        $viewData = [
            'survey' => $survey,
            'response' => $res,
            'student' => $student,
            'major' => $major,
        ];

        return view('admin.pages.admin.alumni-show', $viewData);
    }
}
