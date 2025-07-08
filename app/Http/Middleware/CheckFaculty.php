<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Enums\Role;
use App\Services\SsoService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckFaculty
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Kiểm tra xem người dùng đã đăng nhập chưa
        if (!auth()->check()) {
            return redirect()->route('dashboard');
        }

        $user = auth()->user();
        $userData = $user->user_data;

        // Nếu không có dữ liệu người dùng, thử lấy từ API
        if (!$userData) {
            $userData = app(SsoService::class)->getDataUser();
            if (!$userData) {
                return redirect()->route('dashboard');
            }
        }

        if ($userData['role'] === Role::Normal->value) {
            abort(403);
        }

        $facultyId = $userData['role'] === Role::SuperAdmin->value
            ? $user->faculty_id
            : $userData['faculty_id'] ?? null;

        if (!$facultyId) {
            return redirect()->route('dashboard');
        }

        return $next($request);
    }
}
