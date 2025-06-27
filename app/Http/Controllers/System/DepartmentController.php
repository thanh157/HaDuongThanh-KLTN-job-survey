<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        $path = base_path('app/JSON/Department.json');
        $departments = [];

        if (File::exists($path)) {
            $data = File::get($path);
            $departments = json_decode($data, true);
        }

        $departments = collect($departments);

        // Lọc theo mã bộ môn
        if ($request->filled('ma_bo_mon')) {
            $departments = $departments->filter(function ($item) use ($request) {
                return Str::contains(Str::lower($item['code']), Str::lower($request->ma_bo_mon));
            });
        }

        // Lọc theo tên bộ môn
        if ($request->filled('ten_bo_mon')) {
            $departments = $departments->filter(function ($item) use ($request) {
                return Str::contains(Str::lower($item['name']), Str::lower($request->ten_bo_mon));
            });
        }

        // Lọc theo trạng thái
        if ($request->filled('trang_thai')) {
            $departments = $departments->filter(function ($item) use ($request) {
                return $item['status'] === $request->trang_thai;
            });
        }

        // Sắp xếp theo ngày tạo
        if ($request->sap_xep === 'moi_nhat') {
            $departments = $departments->sortByDesc('created_at');
        } elseif ($request->sap_xep === 'cu_nhat') {
            $departments = $departments->sortBy('created_at');
        }

        return view('admin.pages.admin.department', [
            'departments' => $departments->values()
        ]);
    }
}
