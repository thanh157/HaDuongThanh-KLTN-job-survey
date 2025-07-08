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

        $response = $this->studentService->get("/api/v1/external/graduation-ceremonies/faculty/{$facultyId}", [
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

        return match ($chart) {
            'chart_surveyed' => $this->chartSurveyed($query),
            'chart_employment_status' => $this->chartEmploymentStatus($query),
            'chart_employment_time' => $this->chartEmploymentTime($query),
            'chart_company_name' => $this->chartCompanyName($query),
            'chart_work_sector' => $this->chartWorkSector($query),
            'chart_job_position' => $this->chartJobPosition($query),
            'chart_job_relevance' => $this->chartJobRelevance($query),
            'chart_income' => $this->chartIncome($query),
            default => response()->json(['error' => 'Biểu đồ không hợp lệ.'], 400),
        };
    }

    private function chartSurveyed($query)
    {
        $count = $query->count();
        return response()->json([
            'type' => 'pie',
            'labels' => ['Đã khảo sát'],
            'data' => [$count]
        ]);
    }

    private function chartEmploymentStatus($query)
    {
        $map = [1 => 'Đã có việc', 2 => 'Chưa có việc', 3 => 'Tiếp tục học'];
        $data = $query->select('employment_status', DB::raw('count(*) as count'))
            ->groupBy('employment_status')
            ->pluck('count', 'employment_status')
            ->toArray();

        return response()->json([
            'type' => 'pie',
            'labels' => array_values(array_intersect_key($map, $data)),
            'data' => array_values($data)
        ]);
    }

    private function chartEmploymentTime($query)
    {
        $map = [1 => '<3 tháng', 2 => '3-6 tháng', 3 => '6-12 tháng', 4 => '>12 tháng'];
        $data = $query->select('employed_since', DB::raw('count(*) as count'))
            ->groupBy('employed_since')
            ->pluck('count', 'employed_since')
            ->toArray();

        return response()->json([
            'type' => 'bar',
            'labels' => array_values(array_intersect_key($map, $data)),
            'data' => array_values($data),
            'horizontal' => false
        ]);
    }

    private function chartCompanyName($query)
    {
        $data = $query->select('recruit_partner_name as name', DB::raw('count(*) as count'))
            ->groupBy('recruit_partner_name')
            ->orderByDesc('count')
            ->limit(10)
            ->get();

        return response()->json([
            'type' => 'pie',
            'labels' => $data->pluck('name'),
            'data' => $data->pluck('count')
        ]);
    }

    private function chartWorkSector($query)
    {
        $map = [1 => 'Nhà nước', 2 => 'Tư nhân', 3 => 'Nước ngoài', 4 => 'Tự tạo việc'];
        $data = $query->select('work_area', DB::raw('count(*) as count'))
            ->groupBy('work_area')
            ->pluck('count', 'work_area')
            ->toArray();

        return response()->json([
            'type' => 'pie',
            'labels' => array_values(array_intersect_key($map, $data)),
            'data' => array_values($data)
        ]);
    }

    private function chartJobPosition($query)
    {
        $data = $query->select('recruit_partner_position as name', DB::raw('count(*) as count'))
            ->groupBy('recruit_partner_position')
            ->orderByDesc('count')
            ->limit(10)
            ->get();

        return response()->json([
            'type' => 'pie',
            'labels' => $data->pluck('name'),
            'data' => $data->pluck('count')
        ]);
    }

    private function chartJobRelevance($query)
    {
        $map = [1 => 'Đúng ngành', 2 => 'Liên quan', 3 => 'Không liên quan'];
        $data = $query->select('trained_field', DB::raw('count(*) as count'))
            ->groupBy('trained_field')
            ->pluck('count', 'trained_field')
            ->toArray();

        return response()->json([
            'type' => 'pie',
            'labels' => array_values(array_intersect_key($map, $data)),
            'data' => array_values($data)
        ]);
    }

    private function chartIncome($query)
    {
        $data = $query->select(DB::raw("CASE 
                WHEN average_income < 5 THEN '<5 triệu'
                WHEN average_income BETWEEN 5 AND 10 THEN '5-10 triệu'
                WHEN average_income BETWEEN 11 AND 15 THEN '10-15 triệu'
                ELSE '>15 triệu' END as range"),
                DB::raw('count(*) as count'))
            ->groupBy('range')
            ->get();

        return response()->json([
            'type' => 'bar',
            'labels' => $data->pluck('range'),
            'data' => $data->pluck('count'),
            'horizontal' => false
        ]);
    }
}