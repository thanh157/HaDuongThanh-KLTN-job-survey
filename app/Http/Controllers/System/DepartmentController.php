<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\SsoService;
use Illuminate\Support\Arr;

class DepartmentController extends Controller
{
    public function __construct(private SsoService $ssoService)
    {
    }

    public function index(Request $request)
    {
        $facultyId = $this->ssoService->getFacultyId();
        // get department from sso platform
        // generate token from client_id and client_secret from .env
        $token = cache()->remember(
            'token_client', 
            60 * 5, // Cache trong 5 phút
            fn () => $this->ssoService->post('/oauth/token', [
                'grant_type' => 'client_credentials',
                'client_id' => config('auth.sso.client_id'),
                'client_secret' => config('auth.sso.client_secret'),
            ])
        );

        $departments = cache()->remember(
            'api_departments_' . $facultyId, 
            60 * 5, // Cache trong 5 phút
            fn () => $this->ssoService->get('/api/faculties/' . $facultyId . '/departments', [
                'access_token' => Arr::get($token, 'access_token')
            ])
        );

        // return data to view
        return view('admin.pages.admin.department', [
            'departments' => $departments
        ]);
    }
}
