<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Chuyển hướng sang SSO server
    public function redirectToSSO(Request $request)
    {
        $query = http_build_query([
            'client_id' => config('services.sso.client_id'),
            'redirect_uri' => config('services.sso.redirect'),
            'response_type' => 'code',
            'scope' => 'openid profile email', // tuỳ chỉnh scope nếu SSO server yêu cầu
            'state' => csrf_token(),
        ]);
        $ssoUrl = rtrim(config('services.sso.base_uri'), '/') . '/oauth/authorize?' . $query;
        return redirect($ssoUrl);
    }

    // Nhận callback từ SSO server
    public function handleSSOCallback(Request $request)
    {
        $code = $request->input('code');
        if (!$code) {
            return redirect()->route('admin.login')->withErrors(['msg' => 'Không nhận được mã xác thực từ SSO.']);
        }

        // Lấy access_token từ SSO server
        $response = Http::asForm()->post(rtrim(config('services.sso.base_uri'), '/') . '/oauth/token', [
            'grant_type' => 'authorization_code',
            'client_id' => config('services.sso.client_id'),
            'client_secret' => config('services.sso.client_secret'),
            'redirect_uri' => config('services.sso.redirect'),
            'code' => $code,
        ]);

        if (!$response->ok()) {
            return redirect()->route('admin.login')->withErrors(['msg' => 'Không lấy được access token từ SSO.']);
        }

        $accessToken = $response->json('access_token');
        if (!$accessToken) {
            return redirect()->route('admin.login')->withErrors(['msg' => 'Access token không hợp lệ.']);
        }

        // TẠM THỜI BỎ QUA GỌI API SSO LẤY USER (do phía SSO chưa có API)
        // $userResponse = Http::withToken($accessToken)
        //     ->withHeaders(['api-key' => config('services.sso.api_key')])
        //     ->get(rtrim(config('services.sso.base_uri'), '/') . '/api/user');
        // if (!$userResponse->ok()) {
        //     return redirect()->route('admin.login')->withErrors(['msg' => 'Không lấy được thông tin người dùng từ SSO.']);
        // }
        // $ssoUser = $userResponse->json();
        // TẠM THỜI GIẢ LẬP USER
        $ssoUser = [
            'email' => 'test@example.com',
            'name' => 'Test User',
        ];

        // Tuỳ chỉnh mapping thông tin user theo response của SSO server
        $user = \App\Models\User::firstOrCreate(
            ['email' => $ssoUser['email']],
            [
                'name' => $ssoUser['name'] ?? $ssoUser['email'],
                // Thêm các trường khác nếu cần
            ]
        );
        Auth::login($user);
        return redirect()->route('admin.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('sso.redirect');
    }
} 