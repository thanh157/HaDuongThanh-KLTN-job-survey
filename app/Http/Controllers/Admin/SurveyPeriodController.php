<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SsoService;
use Illuminate\Support\Arr;

class FormSurveyController extends Controller
{
    public function showForm()
    {
        $facultyId = app(SsoService::class)->getFacultyId();

        $token = cache()->remember('token_client', 300, function () {
            return app(SsoService::class)->post('/oauth/token', [
                'grant_type' => 'client_credentials',
                'client_id' => config('auth.sso.client_id'),
                'client_secret' => config('auth.sso.client_secret'),
            ]);
        });

        $response = app(SsoService::class)->get("/api/faculties/{$facultyId}/majors", [
            'access_token' => Arr::get($token, 'access_token'),
        ]);

        $majors = $response['data'] ?? [];

        // View đúng tên
        return view('admin.pages.admin.form-survey-student', compact('majors'));
    }
}
