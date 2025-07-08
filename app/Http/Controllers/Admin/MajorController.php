<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\StudentService;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class MajorController extends Controller
{
    protected $studentService;

    public function __construct(StudentService $studentService)
    {
        $this->studentService = $studentService;
    }

    public function index(Request $request)
    {
        // Lấy token truy cập từ cache hoặc tạo mới |Kiểm tra cache để lấy access_token, nếu chưa có thì tạo mới.
        $facultyId = $this->studentService->getFacultyId();
        $token = cache()->remember('token_client1', 300, function () {
            return $this->studentService->post('/oauth/token', [
                'grant_type' => 'client_credentials',
                'client_id' => config('auth.student.client_id'),
                'client_secret' => config('auth.student.client_secret'),
            ]);
        });

        $response = $this->studentService->get("/api/v1/external/training-industries/faculty/{$facultyId}", [
            'access_token' => Arr::get($token, 'access_token'),
        ]);

        $majors = collect($response['data'] ?? [])->map(function ($major) {
            $major['status'] = $major['status'] ?? 'active'; // mặc định
            return $major;
        });

        // Filter
        $tenNganh = $request->query('ten_nganh');
        $trangThai = $request->query('trang_thai');
        $sapXep = $request->query('sap_xep');

        if ($tenNganh) {
            $majors = $majors->filter(function ($item) use ($tenNganh) {
                return Str::contains(Str::lower($item['name']), Str::lower($tenNganh));
            });
        }

        if ($trangThai) {
            $majors = $majors->where('status', $trangThai);
        }

        if ($sapXep === 'moi_nhat') {
            $majors = $majors->sortByDesc('created_at');
        } elseif ($sapXep === 'cu_nhat') {
            $majors = $majors->sortBy('created_at');
        }

        return view('admin.pages.admin.major', [
            'majors' => $majors->values(),
        ]);
    }
}
