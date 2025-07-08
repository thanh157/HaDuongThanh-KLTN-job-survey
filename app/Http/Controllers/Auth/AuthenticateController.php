<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Enums\Role;
use App\Enums\Status;
use App\Enums\UserType;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\SsoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class AuthenticateController extends Controller
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
            $data = $this->getAccessToken($request->code);

            if (! isset($data['access_token'])) {
                Log::error('SSO authentication failed: No access token received', ['response' => $data]);
                return abort(401, 'Authentication failed');
            }

            $userData = $this->getUserData($data['access_token']);
            $this->validateUserData($userData);
            $user = $this->findOrCreateUser($userData, $data['access_token']);

            Auth::login($user);

            return redirect()->route('admin.dashboard');
        } catch (Throwable $th) {
            Log::error('SSO authentication error: ' . $th->getMessage(), [
                'code' => $request->code,
                'file' => $th->getFile(),
                'line' => $th->getLine()
            ]);

            return abort(401, 'Authentication failed. Please try again later.');
        }
    }

    public function logout()
    {
        app(SsoService::class)->clearAuth();

        return redirect(config('auth.sso.uri'));
    }

    private function getAccessToken(string $code): array
    {
        $response = Http::timeout(600)->asForm()->post(config('auth.sso.ip') . '/oauth/token', [
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
        $response = Http::withToken($accessToken)->get(config('auth.sso.ip') . '/api/user');

        return $response->json();
    }

    private function findOrCreateUser(array $userData, string $accessToken): User
    {
        $user = User::where('sso_id', $userData['id'])->first();

        $facultyId = null;
        if ($userData['role'] !== Role::SuperAdmin->value && !empty($userData['faculty_id'])) {
            $facultyId = $userData['faculty_id'];
        }

        $userData = array_merge($userData, ['access_token' => $accessToken]);

        if (!$user) {
            $userType = $this->determineUserType($userData['role']);
            $user = User::create([
                'sso_id' => $userData['id'],
                'status' => Status::Active,
                'full_name' => $userData['full_name'],
                'code' => $userData['code'] ?? null,
                'access_token' => $accessToken,
                'user_data' => $userData,
                'faculty_id' => $facultyId,
                'role' => $userData['role'],
                'type' => $userType
            ]);
        } else {
            $userType = $this->determineUserType($userData['role']);
            $user->update([
                'full_name' => $userData['full_name'],
                'code' => $userData['code'] ?? null,
                'access_token' => $accessToken,
                'user_data' => $userData,
                'faculty_id' => $facultyId,
                'role' => $userData['role'],
                'type' => $userType
            ]);
        }

        return $user;
    }

    private function validateUserData(array $userData): void
    {
        if ($userData['role'] !== Role::SuperAdmin->value && empty($userData['faculty_id'])) {
            abort(403);
        }

        if ($userData['role'] === Role::Normal->value || $userData['role'] === Role::Student->value) {
            abort(403);
        }
    }

    private function determineUserType(string $role): string
    {
        return match ($role) {
            Role::SuperAdmin->value => UserType::Admin->value,
            Role::Officer->value => UserType::Officer->value,
            default => UserType::Teacher->value,
        };
    }
}
