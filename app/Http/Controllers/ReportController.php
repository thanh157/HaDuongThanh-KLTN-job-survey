<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\StudentService;
use Illuminate\Support\Arr;
use Illuminate\Pagination\LengthAwarePaginator;


class ReportController extends Controller
{
    public function __construct(private StudentService $studentService) {}

    public function index(Request $request)
    {
        // 1. Lấy faculty_id của người dùng hiện tại
        $facultyId = $this->studentService->getFacultyId();

        // 2. Lấy access token từ cache hoặc gọi mới
        $token = cache()->remember('token_client1', 300, fn() => $this->studentService->post('/oauth/token', [
            'grant_type' => 'client_credentials',
            'client_id' => config('auth.student.client_id'),
            'client_secret' => config('auth.student.client_secret'),
        ]));


        $accessToken = Arr::get($token, 'access_token');

        // 3. Lấy danh sách đợt tốt nghiệp từ API
        $graduationList = cache()->remember(
            "graduation_list_faculty_$facultyId",
            300,
            fn() =>
            $this->studentService->get("/api/v1/external/graduation-ceremonies/faculty/$facultyId", [
                'access_token' => $accessToken
            ])
        );

        $graduations = collect($graduationList['data'] ?? []);
        $selectedGraduationId = $request->input('graduation_id') ?? optional($graduations->first())['id'];

        // 4. Lấy ngành đào tạo từ API
        $industryList = $this->studentService->get("/api/v1/external/training-industries/faculty/$facultyId", [
            'access_token' => $accessToken
        ]);
        $industries = collect($industryList['data'] ?? [])->map(fn($i) => (object)$i);

        // 5. Lấy toàn bộ phản hồi sinh viên từ DB
        $surveyResponses = DB::table('employment_survey_responses')->get();

        // Mẫu 1
        $report1 = $industries->map(function ($industry) use ($surveyResponses) {
            $responses = $surveyResponses->filter(fn($r) => ($r->training_industry_id ?? null) == $industry->id);

            $total = $responses->count();
            $female = $responses->filter(fn($r) => strtolower($r->gender ?? '') === 'female')->count();
            $hasJob = $responses->filter(fn($r) => $r->employment_status == 1)->count();
            $stillStudy = $responses->filter(fn($r) => $r->employment_status == 2)->count();
            $noJob = $responses->filter(fn($r) => $r->employment_status == 3)->count();

            $viecDungNganh = $responses->filter(fn($r) => $r->employment_status == 3)->count();
            $viecLienQuan = $responses->filter(fn($r) => $r->employment_status == 4)->count();
            $viecKhongLienQuan = $responses->filter(fn($r) => $r->employment_status == 5)->count();

            $lamNN = $responses->filter(fn($r) => $r->work_area == 1)->count();       // Nhà nước
            $lamTuNhan = $responses->filter(fn($r) => $r->work_area == 2)->count();   // Tư nhân
            $tuTaoViecLam = $responses->filter(fn($r) => $r->work_area == 3)->count(); // Tự tạo việc làm
            $lamViecNNg = $responses->filter(fn($r) => $r->work_area == 4)->count();  // Nước ngoài

            $noiLamViec = $responses->pluck('work_location')->unique()->implode(', ');

            return (object)[
                'training_industry_id' => $industry->code,
                'ten_nganh' => $industry->name,
                'sv_tot_nghiep' => $total,
                'sv_nu_tot_nghiep' => $female,
                'tong_phan_hoi' => $total,
                'nu_phan_hoi' => $female,
                'co_viec_lam' => $hasJob,
                'viec_lam_dung_nganh' => $viecDungNganh,
                'viec_lam_lien_quan' => $viecLienQuan,
                'viec_lam_khong_lien_quan' => $viecKhongLienQuan,
                'tiep_tuc_hoc' => $stillStudy,
                'chua_co_viec' => $noJob,
                'ty_le_co_viec_phan_hoi' => $total > 0 ? round($hasJob / $total * 100, 2) : 0,
                'ty_le_co_viec_tot_nghiep' => $total > 0 ? round($hasJob / $total * 100, 2) : 0,
                'lam_viec_nha_nuoc' => $lamNN,
                'lam_viec_tu_nhan' => $lamTuNhan,
                'tu_tao_viec_lam' => $tuTaoViecLam,
                'yeu_to_nuoc_ngoai' => $lamViecNNg,
                'noi_lam_viec' => $noiLamViec,
            ];
        });

        // mãu2

        $surveyMethods = ['Online', 'Điện thoại', 'Email'];
        $page = request('page', 1); // Trang hiện tại
        $perPage = 10; // Số dòng mỗi trang

        // 1. Tạo toàn bộ dữ liệu report2
        $report2All = $surveyResponses->map(function ($r, $index) use ($industries, $surveyMethods) {
            $industry = $industries->firstWhere('id', $r->training_industry_id);

            return (object)[
                'stt' => $index + 1,
                'student_code' => $r->code_student ?? '',
                'full_name' => $r->full_name ?? '',
                'gender' => strtolower($r->gender ?? '') === 'female' ? 1 : '',
                'citizen_id' => $r->identification_card_number ?? '',
                'training_industry_code' => $industry->code ?? '',
                'training_industry_name' => $industry->name ?? '',
                'graduation_decision_number' => '122/QĐ-HV',
                'graduation_decision_date' => '08/01/2021',
                'phone' => $r->phone_number ?? '',
                'email' => $r->email ?? '',
                'survey_method' => $surveyMethods[array_rand($surveyMethods)],
                'has_response' => 1, // Luôn có phản hồi
                'faculty_name' => 'Công nghệ Thông tin',
            ];
        });

        // 2. Phân trang thủ công
        $report2 = new LengthAwarePaginator(
            $report2All->slice(($page - 1) * $perPage, $perPage)->values(),
            $report2All->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );



        // mẫu 3

        $page = request('page', 1);
        $perPage = 10;

        // 1. Tạo toàn bộ dữ liệu report3
        $report3All = $surveyResponses->map(function ($r, $index) use ($industries) {
            $industry = $industries->firstWhere('id', $r->training_industry_id);

            return (object)[
                'stt' => $index + 1,
                'student_code' => $r->code_student ?? '',
                'full_name' => $r->full_name ?? '',
                'dob' => $r->dob ? \Carbon\Carbon::parse($r->dob)->format('d/m/Y') : '',
                'gender' => strtolower($r->gender) === 'female' ? 'Nữ' : 'Nam',
                'citizen_id' => $r->identification_card_number ?? '',
                'training_industry_code' => $industry->code ?? '',
                'phone' => $r->phone_number ?? '',
                'email' => $r->email ?? '',

                // Việc làm
                'employed_correct' => 1,
                'employed_related' => 0,
                'employed_irrelevant' => 0,
                'continue_study' => 0,
                'unemployed' => 0,

                // Khu vực làm việc
                'state' => 1,
                'private' => 0,
                'foreign' => 0,
                'self_employed' => 0,

                'city_code' => str_pad($r->city_work_id ?? 0, 2, '0', STR_PAD_LEFT),

                // Thời gian có việc
                'under_3_months' => 1,
                'from_3_to_6' => 0,
                'from_6_to_12' => 0,
                'above_12_months' => 0,

                // Thu nhập
                'under_5m' => 1,
                'from_5_to_10m' => 0,
                'from_10_to_15m' => 0,
                'above_15m' => 0,

                // Kiến thức
                'learned_well' => 1,
                'partly_learned' => 0,
                'not_learned' => 0,

                // Hình thức tìm việc
                'via_school' => 1,
                'via_friends' => 0,
                'self_find' => 0,
                'self_create' => 0,
                'others' => 0,

                // Mức độ áp dụng kiến thức
                'knowledge_very_applied' => 1,
                'knowledge_applied' => 0,
                'knowledge_little' => 0,
                'knowledge_very_little' => 0,
                'knowledge_none' => 0,

                // Mức độ áp dụng kỹ năng
                'skill_very_applied' => 1,
                'skill_applied' => 0,
                'skill_little' => 0,
                'skill_very_little' => 0,
                'skill_none' => 0,

                // Kỹ năng mềm
                'soft_communication' => 1,
                'soft_leadership' => 0,
                'soft_presentation' => 1,
                'soft_english' => 0,
                'soft_teamwork' => 1,
                'soft_it' => 1,
                'soft_writing' => 1,
                'soft_others' => 0,

                // Khóa học
                'course_specialized' => 1,
                'course_skills' => 1,
                'course_it' => 0,
                'course_language' => 1,
                'course_management' => 0,
                'course_higher' => 1,
                'course_others' => 0,

                // Giải pháp
                'solution_alumni' => 1,
                'solution_employers' => 1,
                'solution_employer_train' => 0,
                'solution_update_program' => 1,
                'solution_practice' => 1,
                'solution_others' => 0,
            ];
        });

        // 2. Phân trang thủ công cho report3
        $report3 = new \Illuminate\Pagination\LengthAwarePaginator(
            $report3All->slice(($page - 1) * $perPage, $perPage)->values(),
            $report3All->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );


        return view('admin.pages.admin.report', [
            'report1' => $report1,
            'report2' => $report2,
            'report3' => $report3,
            'graduationList' => $graduations,
            'selectedGraduationId' => $selectedGraduationId,
        ]);
    }
}
