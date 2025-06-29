<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\StudentService;
use Illuminate\Support\Arr;

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
}
