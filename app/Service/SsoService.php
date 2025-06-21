<?php

namespace App\Services;

use App\Enums\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Throwable;
use App\Enums\StatusEnum;
use App\Enums\UserRoleEnum;

class SsoService
{
    private $accessToken;

    public function __construct()
    {
        $this->accessToken = Session::get('access_token');
    }


    public function get(string $endPoint, $data = [])
    {
        try {
            $response = Http::withToken($this->accessToken)->get(config('auth.sso.uri') . $endPoint, $data);

            return $response->json();
        } catch (Throwable $th) {
            Log::error($th->getMessage());

            $this->handleError($th->getCode());

            return [];
        }
    }

    public function post(string $endPoint, $data = [])
    {
        try {
            $response = Http::withToken($this->accessToken)->post(config('auth.sso.uri') . $endPoint, $data);

            return $response->json();
        } catch (Throwable $th) {
            Log::error($th->getMessage());

            $this->handleError($th->getCode());

            return [];
        }
    }

    public function clearAuth(): void
    {
        Auth::logout();
        Session::forget('access_token');
        Session::forget('userData');
        Session::forget('facultyId');
    }

    public function getDataUser()
    {

        $userData = Session::get('userData');

        if (!$userData) {
            app(SsoService::class)->clearAuth();
            return redirect()->route('dashboard');
        }

        return $userData;
    }

    public function getFacultyId()
    {

        $userData = $this->getDataUser();


        return  $userData['role'] === UserRoleEnum::SuperAdmin->value
            ? Session::get('facultyId')
            : $userData['faculty_id'] ?? null;
    }

    private function handleError(int $codeError): void
    {

        if (401 === $codeError) {
            $this->clearAuth();
            abort(401);
        }

        if (404 === $codeError) {
            abort(404);
        }

        if (500 === $codeError) {
            abort(500);
        }

        if (403 === $codeError) {
            abort(403);
        }
    }

    public function getStudentCode()
    {
        $userData = $this->getDataUser();

        return $userData['code'] ?? null;
    }
}