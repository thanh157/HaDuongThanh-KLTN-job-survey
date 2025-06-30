<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\StudentService;
use Illuminate\Support\Arr;

class FormSurveyController extends Controller
{
    protected $studentService;

    public function __construct(StudentService $studentService)
    {
        $this->studentService = $studentService;
    }

    public function showForm()
    {
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
            return (object) $major; // Ép về object
        });

        return view('admin.pages.admin.form-survey-student', [
            'majors' => $majors,
        ]);
    }
}
