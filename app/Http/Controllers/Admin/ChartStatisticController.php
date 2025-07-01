<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\StudentService;
use Illuminate\Support\Arr;
use App\Models\EmploymentSurveyResponse;
use Illuminate\Support\Facades\DB;

class ChartStatisticController extends Controller
{
    public function __construct(private StudentService $studentService) {}

    public function index()
    {
        $facultyId = $this->studentService->getFacultyId();

        $token = cache()->remember('token_client1', 60 * 5, fn() => $this->studentService->post('/oauth/token', [
            'grant_type' => 'client_credentials',
            'client_id' => config('auth.student.client_id'),
            'client_secret' => config('auth.student.client_secret'),
        ]));

        $response = $this->studentService->get('/api/v1/external/graduation-ceremonies/faculty/' . $facultyId, [
            'access_token' => Arr::get($token, 'access_token')
        ]);

        $graduations = collect($response['data'] ?? []);

        return view('admin.pages.admin.charts', compact('graduations'));
    }

    public function getChartData(Request $request)
    {
        $surveyPeriodId = $request->input('survey_period_id');
        $chart = $request->input('chart');

        if (!$surveyPeriodId || !$chart) {
            return response()->json(['error' => 'Thiếu thông tin yêu cầu.'], 400);
        }

        $query = EmploymentSurveyResponse::where('survey_period_id', $surveyPeriodId);

        switch ($chart) {
            case 'chart_surveyed':
                $surveyed = $query->count();
                $notSurveyed = 0; // Nếu có bảng tổng danh sách sinh viên, mới tính được chưa khảo sát
                return response()->json([
                    'type' => 'pie',
                    'labels' => ['Đã khảo sát'],
                    'data' => [$surveyed]
                ]);

            case 'chart_employment_status':
                $map = [
                    1 => 'Đã có việc',
                    2 => 'Chưa có việc',
                    3 => 'Tiếp tục học'
                ];
                $result = $query->select('employment_status', DB::raw('count(*) as count'))
                    ->groupBy('employment_status')->pluck('count', 'employment_status')->toArray();

                return response()->json([
                    'type' => 'pie',
                    'labels' => array_values(array_intersect_key($map, $result)),
                    'data' => array_values($result)
                ]);

            case 'chart_employment_time':
                $map = [
                    1 => '<3 tháng',
                    2 => '3-6 tháng',
                    3 => '6-12 tháng',
                    4 => '>12 tháng'
                ];
                $result = $query->select('employed_since', DB::raw('count(*) as count'))
                    ->groupBy('employed_since')->pluck('count', 'employed_since')->toArray();

                return response()->json([
                    'type' => 'bar',
                    'labels' => array_values(array_intersect_key($map, $result)),
                    'data' => array_values($result),
                    'horizontal' => false
                ]);

            case 'chart_company_name':
                $result = $query->select('recruit_partner_name as name', DB::raw('count(*) as count'))
                    ->groupBy('recruit_partner_name')->orderByDesc('count')->limit(10)->get();

                return response()->json([
                    'type' => 'pie',
                    'labels' => $result->pluck('name'),
                    'data' => $result->pluck('count')
                ]);

            case 'chart_work_sector':
                $map = [
                    1 => 'Nhà nước',
                    2 => 'Tư nhân',
                    3 => 'Nước ngoài',
                    4 => 'Tự tạo việc làm'
                ];
                $result = $query->select('work_area', DB::raw('count(*) as count'))
                    ->groupBy('work_area')->pluck('count', 'work_area')->toArray();

                return response()->json([
                    'type' => 'pie',
                    'labels' => array_values(array_intersect_key($map, $result)),
                    'data' => array_values($result)
                ]);

            case 'chart_job_position':
                $result = $query->select('recruit_partner_position as name', DB::raw('count(*) as count'))
                    ->groupBy('recruit_partner_position')->orderByDesc('count')->limit(10)->get();

                return response()->json([
                    'type' => 'pie',
                    'labels' => $result->pluck('name'),
                    'data' => $result->pluck('count')
                ]);

            case 'chart_job_relevance':
                $map = [
                    1 => 'Đúng ngành',
                    2 => 'Liên quan',
                    3 => 'Không liên quan'
                ];
                $result = $query->select('trained_field', DB::raw('count(*) as count'))
                    ->groupBy('trained_field')->pluck('count', 'trained_field')->toArray();

                return response()->json([
                    'type' => 'pie',
                    'labels' => array_values(array_intersect_key($map, $result)),
                    'data' => array_values($result)
                ]);

            case 'chart_income':
                $result = $query->select(DB::raw("
                    CASE 
                        WHEN average_income < 5 THEN '<5 triệu'
                        WHEN average_income BETWEEN 5 AND 10 THEN '5-10 triệu'
                        WHEN average_income BETWEEN 11 AND 15 THEN '10-15 triệu'
                        ELSE '>15 triệu'
                    END as range
                "), DB::raw('count(*) as count'))
                    ->groupBy('range')->get();

                return response()->json([
                    'type' => 'bar',
                    'labels' => $result->pluck('range'),
                    'data' => $result->pluck('count'),
                    'horizontal' => false
                ]);

            default:
                return response()->json(['error' => 'Biểu đồ không hợp lệ.'], 400);
        }
    }
}
