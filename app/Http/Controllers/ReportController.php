<?php

namespace App\Http\Controllers;

use App\Models\EmploymentSurveyResponse;
use App\Models\GraduationStudent;
use App\Models\Student;
use App\Models\Survey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\StudentService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;

class ReportController extends Controller
{
    public function __construct(private StudentService $studentService) {}

    public function index(Request $request)
    {
        $facultyId = $this->studentService->getFacultyId();


        // 2. Lấy access token từ cache hoặc gọi mới
        $token = cache()->remember('token_client1', 300, fn() => $this->studentService->post('/oauth/token', [
            'grant_type' => 'client_credentials',
            'client_id' => config('auth.student.client_id'),
            'client_secret' => config('auth.student.client_secret'),
        ]));

        $accessToken = Arr::get($token, 'access_token');

        $graduationList = cache()->remember(
            "graduation_list_faculty_$facultyId",
            300,
            fn() => $this->studentService->get("/api/v1/external/graduation-ceremonies/faculty/$facultyId", [
                'access_token' => $accessToken
            ])
        );

        $graduations = collect($graduationList['data'] ?? []);
        $selectedGraduationId = $request->input('graduation_id') ?? optional($graduations->first())['id'];

        $industryList = $this->studentService->get("/api/v1/external/training-industries/faculty/$facultyId", [
            'access_token' => $accessToken
        ]);

        $industries = collect($industryList['data'] ?? [])->map(fn($i) => (object)$i);

        $surveyResponses = DB::table('employment_survey_responses_v2')->get();

        $report1 = $industries->map(function ($industry) use ($surveyResponses) {
            $responses = $surveyResponses->filter(fn($r) => ($r->training_industry_id ?? null) == $industry->id);

            $total = $responses->count();
            $female = $responses->filter(fn($r) => strtolower($r->gender ?? '') === 'female')->count();
            $hasJob = $responses->filter(fn($r) => $r->employment_status == 1)->count();
            $stillStudy = $responses->filter(fn($r) => $r->employment_status == 2)->count();
            $noJob = $responses->filter(fn($r) => $r->employment_status == 3)->count();

            $viecDungNganh = $responses->filter(fn($r) => ($r->employment_status ?? null) == 1)->count();
            $viecLienQuan = $responses->filter(fn($r) => ($r->employment_status ?? null) == 2)->count();
            $viecKhongLienQuan = $responses->filter(fn($r) => ($r->employment_status ?? null) == 3)->count();

            $lamNN = $responses->filter(fn($r) => $r->work_area == 1)->count();
            $lamTuNhan = $responses->filter(fn($r) => $r->work_area == 2)->count();
            $tuTaoViecLam = $responses->filter(fn($r) => $r->work_area == 3)->count();
            $lamViecNNg = $responses->filter(fn($r) => $r->work_area == 4)->count();

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

        $surveyMethods = ['Online', 'Điện thoại', 'Email'];
        $page = request('page', 1);
        $perPage = 10;

        $studentsAll = $surveyResponses->map(function ($r, $index) use ($industries, $surveyMethods) {
            $industry = $industries->firstWhere('id', $r->training_industry_id);

            return (object)[
                'stt' => $index + 1,
                'student_code' => $r->code_student ?? '',
                'full_name' => $r->full_name ?? '',
                'is_female' => strtolower($r->gender ?? '') === 'female',
                'id_number' => $r->identification_card_number ?? '',
                'major_code' => $industry->code ?? '',
                'major_name' => $industry->name ?? '',
                'graduation_decision_number' => '122/QĐ-HV',
                'graduation_decision_date' => '08/01/2021',
                'phone' => $r->phone_number ?? '',
                'email' => $r->email ?? '',
                'survey_method' => $surveyMethods[array_rand($surveyMethods)],
                'has_response' => 1,
                'faculty_name' => 'Công nghệ Thông tin',
            ];
        });

        $report2 = new LengthAwarePaginator(
            $studentsAll->slice(($page - 1) * $perPage, $perPage)->values(),
            $studentsAll->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        $students = $report2;

        $report3 = new LengthAwarePaginator(
            collect([]),
            0,
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );
        $studentsReport3 = $surveyResponses->map(function ($r, $index) use ($industries) {
            $industry = $industries->firstWhere('id', $r->training_industry_id);

            return (object)[
                'student_code' => $r->code_student ?? '',
                'full_name' => $r->full_name ?? '',
                'birth_date' => $r->dob ? \Carbon\Carbon::parse($r->dob)->format('d/m/Y') : '',
                'gender' => strtolower($r->gender ?? '') === 'female' ? 'Nữ' : 'Nam',
                'id_number' => $r->identification_card_number ?? '',
                'major_code' => $industry->code ?? '',
                'phone' => $r->phone_number ?? '',
                'email' => $r->email ?? '',

                'job_status_correct' => 1,
                'job_status_related' => 0,
                'job_status_unrelated' => 0,
                'continued_study' => 0,
                'no_job' => 0,

                'gov_sector' => 1,
                'private_sector' => 0,
                'foreign_involved' => 0,
                'self_employed' => 0,

                'workplace_province_code' => str_pad($r->city_work_id ?? 0, 2, '0', STR_PAD_LEFT),

                'time_under_3m' => 1,
                'time_3_to_6m' => 0,
                'time_6_to_12m' => 0,
                'time_over_12m' => 0,

                'income_under_5m' => 1,
                'income_5_to_10m' => 0,
                'income_10_to_15m' => 0,
                'income_over_15m' => 0,

                'skill_learned' => 1,
                'skill_partial' => 0,
                'skill_none' => 0,

                'job_by_school' => 1,
                'job_by_friends' => 0,
                'job_by_self' => 0,
                'job_self_created' => 0,
                'job_by_other' => 0,

                'apply_very_high' => 1,
                'apply_high' => 0,
                'apply_low' => 0,
                'apply_very_low' => 0,
                'apply_none' => 0,

                'skill_apply_very_high' => 1,
                'skill_apply_high' => 0,
                'skill_apply_low' => 0,
                'skill_apply_very_low' => 0,
                'skill_apply_none' => 0,

                'soft_comm' => 1,
                'soft_lead' => 0,
                'soft_present' => 1,
                'soft_english' => 0,
                'soft_team' => 1,
                'soft_it' => 1,
                'soft_report' => 1,
                'soft_other' => 0,

                'course_prof' => 1,
                'course_skill' => 1,
                'course_it' => 0,
                'course_eng' => 1,
                'course_manage' => 0,
                'course_continue' => 1,
                'course_other' => 0,

                'solution_alumni' => 1,
                'solution_employer' => 1,
                'solution_train_join' => 0,
                'solution_curriculum' => 1,
                'solution_practice' => 1,
                'solution_other' => 0,
            ];
        });
        // $report3 = new LengthAwarePaginator(
        //     $studentsReport3->slice(($page - 1) * $perPage, $perPage)->values(),
        //     $studentsReport3->count(),
        //     $perPage,
        //     $page,
        //     ['path' => request()->url(), 'query' => request()->query()]
        // );
        $report3 = new LengthAwarePaginator(
            $studentsReport3->slice(($page - 1) * $perPage, $perPage)->values(),
            $studentsReport3->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        $studentTab2 = [];
        $r1 = [];
        if (request('survey_id')) {
            $survey = Survey::where('id', request('survey_id'))->first();
            if (empty($survey)) {
                abort(404);
            }
            $allDotTotNghiep = $survey->graduations()->get();
            $ids = $survey->graduations()->pluck('id')->toArray();
            $studentIds = GraduationStudent::whereIn('graduation_id', $ids)->pluck('student_id')->toArray();
            $studentTab2 = Student::query()->whereIn('id', $studentIds)->get();
            $schoolYear = !empty($allDotTotNghiep[0]->school_year) ? $allDotTotNghiep[0]->school_year : '';
            $r2 = EmploymentSurveyResponse::query()->where('survey_period_id', request('survey_id'))->get();


            $r1['total_student'] = count($studentTab2);
            $r1['total_nu'] = 0;
            foreach ($studentTab2 as $item) {
                if ($item->gender == 'female') {
                    $r1['total_nu']++;
                }
            }
            $r1['total_res'] = count($r2);
            $r1['total_res_nu'] = 0;
            foreach ($r2 as $item) {
                if ($item->gender == 'female') {
                    $r1['total_res_nu']++;
                }
            }
            $r1_trained_field = EmploymentSurveyResponse::query()
                ->selectRaw("SUM(CASE WHEN employment_status = 1 THEN 1 ELSE 0 END) AS dung_nganh")
                ->selectRaw("SUM(CASE WHEN employment_status = 2 THEN 1 ELSE 0 END) AS lien_quan")
                ->selectRaw("SUM(CASE WHEN employment_status = 3 THEN 1 ELSE 0 END) AS khong_lien_quan")
                ->where('survey_period_id', request('survey_id'))
                ->first();
            $r1_work_area = EmploymentSurveyResponse::query()
                ->selectRaw("SUM(CASE WHEN work_area = 1 THEN 1 ELSE 0 END) AS nha_nuoc")
                ->selectRaw("SUM(CASE WHEN work_area = 2 THEN 1 ELSE 0 END) AS tu_nhan")
                ->selectRaw("SUM(CASE WHEN work_area = 3 THEN 1 ELSE 0 END) AS tu_tao")
                ->selectRaw("SUM(CASE WHEN work_area = 4 THEN 1 ELSE 0 END) AS nuoc_ngoai")
                ->where('survey_period_id', request('survey_id'))
                ->first();
        }

        return view('admin.pages.admin.report', [
            'report1' => $report1,
            'students' => $students,
            'report3' => $report3,
            'graduationList' => $graduations,
            'selectedGraduationId' => $selectedGraduationId,
            'survey' => !empty($survey) ? $survey : null,
            'schoolYear' => !empty($schoolYear) ? $schoolYear : null,
            'r1_trained_field' => !empty($r1_trained_field) ? $r1_trained_field : null,
            'r1_work_area' => !empty($r1_work_area) ? $r1_work_area : null,
            'studentTab2' => $studentTab2,
            'r2' => !empty($r2) ? $r2 : [],
            'r1' => $r1,
        ]);
    }
}
