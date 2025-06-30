<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\StudentService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use App\Models\Graduation;

class GraduationController extends Controller
{
    public function __construct(private StudentService $studentService)
    {
    }

    public function index(Request $request)
    {
        $facultyId = $this->studentService->getFacultyId();
        // get department from sso platform
        // generate token from client_id and client_secret from .env
        $token = cache()->remember(
            'token_client1', 
            60 * 5, // Cache trong 5 phút
            fn () => $this->studentService->post('/oauth/token', [
                'grant_type' => 'client_credentials',
                'client_id' => config('auth.student.client_id'),
                'client_secret' => config('auth.student.client_secret'),
            ])
        );

        $graduations = cache()->remember(
            'api_departments_2' . $facultyId, 
            60 * 5, // Cache trong 5 phút
            fn () => $this->studentService->get('/api/v1/external/graduation-ceremonies/faculty/' . $facultyId, [
                'access_token' => Arr::get($token, 'access_token')
            ])
        );

        // return data to view
        return view('admin.pages.admin.graduation', [
            'graduations' => $graduations
        ]);
    }
    public function create()
    {
        return view('admin.pages.admin.graduation-create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'dot_tot_nghiep' => 'required|string',
            'nam_tot_nghiep' => 'required|string',
            'tong_sinh_vien' => 'required|numeric',
        ]);

        $path = base_path('app/JSON/Graduation.json');
        $graduations = File::exists($path) ? json_decode(File::get($path), true) : [];

        $newId = collect($graduations)->max('id') + 1;

        $data = [
            'id' => $newId,
            'dot_tot_nghiep' => $request->dot_tot_nghiep,
            'nam_tot_nghiep' => $request->nam_tot_nghiep,
            'tong_sinh_vien' => $request->tong_sinh_vien,
            'created_at' => now()->format('Y-m-d H:i:s'), // đảm bảo giờ đúng
        ];

        $graduations[] = $data;

        File::put($path, json_encode($graduations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        return redirect()->route('admin.graduation.index')->with('success', 'Thêm đợt tốt nghiệp thành công!');
    }

    public function edit($id)
    {
        $path = base_path('app/JSON/Graduation.json');
        $graduations = File::exists($path) ? json_decode(File::get($path), true) : [];

        $item = collect($graduations)->firstWhere('id', (int) $id);
        if (!$item) return redirect()->route('admin.graduation.index')->with('error', 'Không tìm thấy đợt tốt nghiệp.');

        return view('admin.pages.admin.graduation-edit', compact('item'));
    }

    public function destroy($id)
    {
        $path = base_path('app/JSON/Graduation.json');
        $graduations = File::exists($path) ? json_decode(File::get($path), true) : [];

        $graduations = array_filter($graduations, fn($item) => $item['id'] != $id);
        File::put($path, json_encode(array_values($graduations), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        return redirect()->route('admin.graduation.index')->with('success', 'Đã xoá đợt tốt nghiệp.');
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'dot_tot_nghiep' => 'required|string',
            'nam_tot_nghiep' => 'required|string',
            'tong_sinh_vien' => 'required|numeric',
        ]);

        $path = base_path('app/JSON/Graduation.json');
        $graduations = File::exists($path) ? json_decode(File::get($path), true) : [];

        foreach ($graduations as &$item) {
            if ($item['id'] == $id) {
                $item['dot_tot_nghiep'] = $request->input('dot_tot_nghiep');
                $item['nam_tot_nghiep'] = $request->input('nam_tot_nghiep');
                $item['tong_sinh_vien'] = $request->input('tong_sinh_vien');
                $item['updated_at'] = now()->format('Y-m-d H:i:s');
                break;
            }
        }

        File::put($path, json_encode($graduations, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        return redirect()->route('admin.graduation.index')->with('success', 'Sửa đợt tốt nghiệp thành công!');
    }
}
