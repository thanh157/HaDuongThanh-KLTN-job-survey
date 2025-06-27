<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MajorController extends Controller
{
    public function index(Request $request)
    {
        $path = base_path('app/JSON/Major.json');
        $majors = [];

        if (File::exists($path)) {
            $data = File::get($path);
            $majors = json_decode($data, true);
        }

        $majors = collect($majors);

        // Lọc theo mã ngành
        if ($request->filled('ma_nganh')) {
            $majors = $majors->filter(function ($item) use ($request) {
                return Str::contains(Str::lower($item['code']), Str::lower($request->ma_nganh));
            });
        }

        // Lọc theo tên ngành
        if ($request->filled('ten_nganh')) {
            $majors = $majors->filter(function ($item) use ($request) {
                return Str::contains(Str::lower($item['name']), Str::lower($request->ten_nganh));
            });
        }

        // Lọc theo trạng thái
        if ($request->filled('trang_thai')) {
            $majors = $majors->filter(function ($item) use ($request) {
                return $item['status'] === $request->trang_thai;
            });
        }

        // Sắp xếp theo ngày tạo
        if ($request->sap_xep === 'moi_nhat') {
            $majors = $majors->sortByDesc('created_at');
        } elseif ($request->sap_xep === 'cu_nhat') {
            $majors = $majors->sortBy('created_at');
        }

        return view('admin.pages.admin.major', [
            'majors' => $majors->values()
        ]);
    }
}
