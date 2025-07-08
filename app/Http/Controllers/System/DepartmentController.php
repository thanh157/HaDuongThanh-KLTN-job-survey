<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\SsoService;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class DepartmentController extends Controller
{
    public function __construct(private SsoService $ssoService) {}

    public function index(Request $request)
    {
        $facultyId = $this->ssoService->getFacultyId();

        // Lấy token
        $token = cache()->remember('token_client', 60 * 5, fn() => $this->ssoService->post('/oauth/token', [
            'grant_type' => 'client_credentials',
            'client_id' => config('auth.sso.client_id'),
            'client_secret' => config('auth.sso.client_secret'),
        ]));

        // Gọi API bộ môn
        $response = cache()->remember("api_departments_{$facultyId}", 60 * 5, fn() => $this->ssoService->get(
            "/api/faculties/{$facultyId}/departments",
            ['access_token' => Arr::get($token, 'access_token')]
        ));

        $departments = collect($response['data'] ?? [])->map(function ($item) {
            $item['status'] = $item['status'] ?? 'active';
            return $item;
        });

        // Lọc theo request
        $tenBoMon = $request->query('ten_bo_mon');
        $trangThai = $request->query('trang_thai');
        $sapXep = $request->query('sap_xep');

        if ($tenBoMon) {
            $departments = $departments->filter(fn($d) => Str::contains(Str::lower($d['name']), Str::lower($tenBoMon)));
        }

        if ($trangThai) {
            $departments = $departments->where('status', $trangThai);
        }

        if ($sapXep === 'moi_nhat') {
            $departments = $departments->sortByDesc('created_at');
        } elseif ($sapXep === 'cu_nhat') {
            $departments = $departments->sortBy('created_at');
        }

        return view('admin.pages.admin.department', [
            'departments' => ['data' => $departments->values()]
        ]);
    }
}
