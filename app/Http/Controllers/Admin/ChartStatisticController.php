<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Survey;
use Illuminate\Http\Request;
use App\Services\StudentService;
use Illuminate\Support\Arr;
use App\Models\EmploymentSurveyResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ChartStatisticController extends Controller
{
    public function __construct(private StudentService $studentService) {}

    public function index()
    {
        $attribute = request('select');
        $survey = Survey::get();
        $rawSurveys = [];
        $config = config('config.' . $attribute);

        if (empty($attribute)) {
            $viewData = [
                'charts' => [],
                'attribute' => '',
            ];
            return view('admin.pages.admin.charts', $viewData);
        }

        $charts = [];
        if (in_array($attribute, ['recruitment_type', 'job_search_method', 'soft_skills_required', 'must_attended_courses', 'solutions_get_job'])) {
            $statCounts = [];
            foreach ($survey as $item) {
                $results = EmploymentSurveyResponse::where('survey_period_id', $item->id)->pluck($attribute);

//                $statCounts = [];

                // Khởi tạo tất cả lựa chọn với giá trị = 0
                foreach ($config as $id => $label) {
                    $statCounts[$label] = 0;
                }

                foreach ($results as $json) {
                    $data = json_decode($json, true);

                    if (json_last_error() === JSON_ERROR_NONE && is_array($data)) {
                        $values = $data['value'] ?? [];

                        if (is_array($values)) {
                            foreach ($values as $idStr) {
                                $id = (int) $idStr;

                                if (isset($config[$id])) {
                                    $label = $config[$id];
                                    $statCounts[$label]++;
                                }
                            }
                        }
                    }
                }

                // Thêm vào mảng charts cho từng kỳ khảo sát
                $charts[] = [
                    'name' => $item->title ?? 'Không rõ',
                    'data' => $statCounts
                ];
            }

            $viewData = [
                'charts' => $charts,
                'attribute' => $attribute,
            ];

//            dd($charts);

        } else {
            foreach ($survey as $item) {
                $results = EmploymentSurveyResponse::where('survey_period_id', $item->id)->pluck($attribute);
                $stats = [];
                foreach ($config as $k => $v) {
                    $stats[$k] = 0;
                }

                foreach ($results as $status) {
                    foreach ($stats as $k => $v) {
                        if ($status == $k) {
                            $stats[$k] += 1;
                        }
                    }
                }

                $rawSurveys[] = [
                    'survey_title' => $item->title,
                    'data' => $stats,
                ];
            }

            foreach ($rawSurveys as $survey) {
                $mappedData = [];

                foreach ($survey['data'] as $key => $count) {
                    $label = $config[$key] ?? "Không xác định";
                    $mappedData[$label] = $count;
                }

                $charts[] = [
                    'name' => $survey['survey_title'],
                    'data' => $mappedData,
                ];
            }
            $viewData = [
                'charts' => $charts,
                'attribute' => $attribute,
            ];
        }

        return view('admin.pages.admin.charts', $viewData);
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
