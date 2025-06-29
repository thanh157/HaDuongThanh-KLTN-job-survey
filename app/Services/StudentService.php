<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Throwable;
use Illuminate\Support\Arr;

class StudentService
{
    private $accessToken;

    public function __construct()
    {
        // Lấy access token từ session, request header hoặc database
        $this->accessToken = $this->getAccessTokenFromSources();
    }


    public function get(string $endPoint, $data = [])
    {
        try {
            $accessToken = $this->accessToken;
            if (Arr::get($data, 'access_token')) {
                $accessToken = Arr::get($data, 'access_token');
            }

            
            $response = Http::withToken($accessToken)->get(config('auth.student.ip') . $endPoint, $data);
            
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
            $response = Http::withToken($this->accessToken)->post(config('auth.student.ip') . $endPoint, $data);

            return $response->json();
        } catch (Throwable $th) {
            Log::error($th->getMessage());

            $this->handleError($th->getCode());

            return [];
        }
    }

    public function clearAuth(): void
    {
        // Xóa dữ liệu trong database nếu đã đăng nhập
        if (auth()->check()) {
            auth()->user()->update([
                'access_token' => null,
                'user_data' => null
            ]);
        }

        // Đăng xuất người dùng
        Auth::logout();
    }

    public function getDataUser()
    {
        // Thử lấy dữ liệu từ database nếu đã đăng nhập
        if (auth()->check()) {
            $userData = auth()->user()->user_data;
            if ($userData) {
                return $userData;
            }
        }

        // Nếu không có dữ liệu trong database và có access token, thử lấy dữ liệu từ API
        if ($this->accessToken) {
            try {
                $response = Http::withToken($this->accessToken)->get(config('auth.student.ip') . '/api/user');
                if ($response->successful()) {
                    $userData = $response->json();

                    // Lưu vào database nếu đã đăng nhập
                    if (auth()->check()) {
                        auth()->user()->update([
                            'user_data' => $userData,
                            'role' => $userData['role']
                        ]);
                    }

                    return $userData;
                }
            } catch (Throwable $th) {
                Log::error('Failed to fetch user data from API: ' . $th->getMessage());
            }
        }

        // Nếu vẫn không có dữ liệu, xóa auth và trả về null
        app(StudentService::class)->clearAuth();
        return null;
    }

    public function getFacultyId()
    {
        // Thử lấy faculty_id từ database nếu đã đăng nhập
        if (auth()->check()) {
            $user = auth()->user();

            // Nếu là SuperAdmin, thử lấy từ database hoặc request
            if ($user->role === Role::SuperAdmin->value) {
                // Thử lấy từ database trước
                if ($user->faculty_id) {
                    return $user->faculty_id;
                }

                // Thử lấy từ request
                if (request()->has('faculty_id')) {
                    $facultyId = request()->input('faculty_id');
                    // Lưu vào database
                    $user->update(['faculty_id' => $facultyId]);
                    return $facultyId;
                }

                return null;
            }

            // Nếu không phải SuperAdmin, trả về faculty_id từ database
            return $user->faculty_id;
        }

        // Nếu chưa đăng nhập, thử lấy từ userData
        $userData = $this->getDataUser();
        if (!$userData) {
            return null;
        }

        return $userData['faculty_id'] ?? null;
    }

    /**
     * Lấy access token từ các nguồn khác nhau
     */
    private function getAccessTokenFromSources(): ?string
    {
        // Thử lấy từ database nếu đã đăng nhập
        if (auth()->check()) {
            return auth()->user()->access_token;
        }

        // Thử lấy từ request header
        $token = request()->bearerToken();
        if ($token) {
            return $token;
        }

        return null;
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
}
