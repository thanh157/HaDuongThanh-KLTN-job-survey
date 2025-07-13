<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\StudentService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

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

        // 6. Xử lý dữ liệu báo cáo theo từng ngành
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

        return view('admin.pages.admin.report', [
            'report1' => $report1,
            'graduationList' => $graduations,
            'selectedGraduationId' => $selectedGraduationId,
        ]);
    }
}
