<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\User;
use App\Services\SsoService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Throwable;
use App\Enums\StatusEnum;
use App\Enums\UserRoleEnum;
use App\Models\Role;

class AuththenticateController extends Controller
{
    public function redirectToSSO()
    {
        $query = http_build_query([
            'client_id' => config('auth.sso.client_id'),
            'redirect_uri' => route('sso.callback'),
            'response_type' => 'code',
            'scope' => '',
        ]);

        return redirect(config('auth.sso.uri') . '/oauth/authorize?' . $query);
    }

    public function handleCallback(Request $request)
    {
        try {
            Log::info('SSO Callback: Received code', ['code' => $request->code]);

            $data = $this->getAccessToken($request->code);
            Log::info('Access token response', $data);
            dd($data);
            if (! isset($data['access_token'])) {
                Log::error('Access token not received.');
                abort(401, 'Không lấy được access token từ SSO');
            }

            Session::put('access_token', $data['access_token']);

            $userData = $this->getUserData($data['access_token']);
            Log::info('User data from SSO', $userData);

            if (empty($userData['id']) || empty($userData['role'])) {
                Log::error('Invalid user data from SSO.');
                abort(401, 'Dữ liệu người dùng không hợp lệ từ SSO');
            }

            $user = $this->findOrCreateUser($userData);
            $this->storeSessionData($userData);

            Auth::login($user);

            if ($userData['role'] === UserRoleEnum::SuperAdmin->value && empty($userData['faculty_id'])) {
                return redirect()->route('faculty.select');
            }

            if ($userData['role'] === UserRoleEnum::Student->value) {
                return redirect()->route('client.dashboard');
            }

            return redirect()->route('dashboard');
        } catch (Throwable $th) {
            Log::error('Lỗi đăng nhập SSO: ' . $th->getMessage());
            abort(401, 'Đã xảy ra lỗi khi xử lý đăng nhập SSO');
        }
    }

    public function logout()
    {
        app(SsoService::class)->clearAuth();
        return redirect(config('auth.sso.uri'));
    }

    private function getAccessToken(string $code): array
    {
        $response = Http::asForm()->post(config('auth.sso.uri') . '/oauth/token', [
            'grant_type' => 'authorization_code',
            'client_id' => config('auth.sso.client_id'),
            'client_secret' => config('auth.sso.client_secret'),
            'redirect_uri' => route('sso.callback'),
            'code' => $code,
        ]);

        return $response->json();
    }

    private function getUserData(string $accessToken): array
    {
        $response = Http::withToken($accessToken)->get(config('auth.sso.uri') . '/api/user');
        return $response->json();
    }

    private function findOrCreateUser(array $userData): User
    {
        $user = User::firstOrCreate(
            ['sso_id' => $userData['id']],
            ['status' => StatusEnum::Active]
        );

        // if ($userData['role'] === UserRoleEnum::Student->value) {
        //     Student::updateOrCreate([
        //         'code' => $userData['code'],
        //     ], [
        //         'user_id' => $user->id,
        //         'email' => $userData['email'] ?? '',
        //         'phone' => $userData['phone'] ?? '',
        //         'code' => $userData['code'],
        //         'name' => ($userData['full_name']),
        //         'faculty_id' => $userData['faculty_id'] ?? null,
        //     ]);
        // }

        if (!empty($userData['faculty_id'])) {
            try {
                $roleIds = $user->userRoles()->pluck('roles.id')->toArray();
                Role::whereIn('id', $roleIds)
                    ->update(['faculty_id' => $userData['faculty_id']]);
            } catch (\Exception $e) {
                Log::error('Error updating faculty_id: ' . $e->getMessage());
            }
        }

        if (
            (User::count() === 1 && $userData['role'] === UserRoleEnum::Officer->value) ||
            ($userData['role'] === UserRoleEnum::SuperAdmin->value)
        ) {
            $superAdminRole = Role::firstOrCreate(['name' => 'Super Admin']);

            if (!$user->userRoles()->where('role_id', $superAdminRole->id)->exists()) {
                $user->userRoles()->attach($superAdminRole->id, ['is_super_admin' => true]);
            } else {
                $user->userRoles()->updateExistingPivot($superAdminRole->id, ['is_super_admin' => true]);
            }
        }

        return $user;
    }

    private function storeSessionData(array $userData): void
    {
        Session::put('userData', $userData);

        // if ($userData['role'] !== UserRoleEnum::SuperAdmin->value && empty($userData['faculty_id'])) {
        //     Log::error('faculty_id bị thiếu với role không phải SuperAdmin');
        //     abort(403, 'Không tìm thấy thông tin khoa');
        // }

        if ($userData['role'] !== UserRoleEnum::SuperAdmin->value) {
            Session::put('faculty_id', $userData['faculty_id']);
        }
    }
}
