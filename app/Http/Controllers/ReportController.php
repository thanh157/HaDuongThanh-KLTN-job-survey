<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\StudentService;
use Illuminate\Support\Arr;

class ReportController extends Controller
{
    public function __construct(private StudentService $studentService) {}

    public function index(Request $request)
    {
        // 1. Danh sách đợt tốt nghiệp (lọc)
        $facultyId = $this->studentService->getFacultyId();
        $token = cache()->remember('token_client1', 300, fn() => $this->studentService->post('/oauth/token', [
            'grant_type' => 'client_credentials',
            'client_id' => config('auth.student.client_id'),
            'client_secret' => config('auth.student.client_secret'),
        ]));

        $graduationList = $this->studentService->get("/api/v1/external/graduation-ceremonies/faculty/$facultyId", [
            'access_token' => Arr::get($token, 'access_token')
        ]);
        $graduations = collect($graduationList['data'] ?? []);
        $selectedGraduationId = $request->input('graduation_id') ?? optional($graduations->first())['id'];

        // 2. Phản hồi sinh viên trong DB
        $surveyResponses = DB::table('employment_survey_responses')->get();


        // 3. Ngành đào tạo
        $industries = DB::table('training_industries')->get();
        $industries->prepend((object)[
            'id' => null,
            'code' => '---',
            'name' => 'Không rõ ngành'
        ]);

        // 4. Báo cáo
        $report1 = $industries->map(function ($industry) use ($surveyResponses) {
            $responses = $surveyResponses->filter(fn($r) => ($r->training_industry_id ?? null) == $industry->id);

            $total = $responses->count();
            $female = $responses->where('gender', 'Nữ')->count();
            $hasJob = $responses->where('employment_status', 1)->count();
            $stillStudy = $responses->where('employment_status', 2)->count();
            $noJob = $responses->where('employment_status', 3)->count();

            return (object)[
                'training_industry_id' => $industry->code,
                'ten_nganh' => $industry->name,
                'sv_tot_nghiep' => $total,
                'sv_nu_tot_nghiep' => $female,
                'tong_phan_hoi' => $total,
                'nu_phan_hoi' => $female,
                'co_viec_lam' => $hasJob,
                'viec_lam_dung_nganh' => null,
                'viec_lam_lien_quan' => null,
                'viec_lam_khong_lien_quan' => null,
                'tiep_tuc_hoc' => $stillStudy,
                'chua_co_viec' => $noJob,
                'ty_le_co_viec_phan_hoi' => $total > 0 ? round($hasJob / $total * 100, 2) : 0,
                'ty_le_co_viec_tot_nghiep' => $total > 0 ? round($hasJob / $total * 100, 2) : 0,
                'lam_viec_nha_nuoc' => null,
                'lam_viec_tu_nhan' => null,
                'tu_tao_viec_lam' => null,
                'yeu_to_nuoc_ngoai' => null,
                'noi_lam_viec' => null,
            ];
        });

        return view('admin.pages.admin.report', [
            'report1' => $report1,
            'graduationList' => $graduations,
            'selectedGraduationId' => $selectedGraduationId,
        ]);
    }
}
