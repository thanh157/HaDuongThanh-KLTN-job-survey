<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class GraduationController extends Controller
{
    public function index(Request $request)
    {
        $path = base_path('app/JSON/Graduation.json');
        $graduations = [];

        if (File::exists($path)) {
            $data = File::get($path);
            $graduations = json_decode($data, true);
        }

        // Lọc theo đợt tốt nghiệp
        if ($request->filled('dot_tot_nghiep')) {
            $graduations = array_filter($graduations, function ($item) use ($request) {
                return Str::contains(Str::lower($item['dot_tot_nghiep']), Str::lower($request->dot_tot_nghiep));
            });
        }

        // Lọc theo năm tốt nghiệp
        if ($request->filled('nam_tot_nghiep')) {
            $graduations = array_filter($graduations, function ($item) use ($request) {
                return Str::contains(Str::lower($item['nam_tot_nghiep']), Str::lower($request->nam_tot_nghiep));
            });
        }

        // Sắp xếp ngày tạo
        if ($request->filled('sap_xep')) {
            usort($graduations, function ($a, $b) use ($request) {
                $timeA = strtotime($a['created_at']);
                $timeB = strtotime($b['created_at']);

                return $request->sap_xep === 'cu_nhat'
                    ? $timeA <=> $timeB
                    : $timeB <=> $timeA;
            });
        }

        return view('admin.pages.admin.graduation', [
            'graduations' => $graduations
        ]);
    }
}
