<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class AuththenticateSSO
{
    /** 
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::check()) {
            $query = http_build_query([
                'client_id' => config('auth.sso.client_id'),
                'redirect_uri' => route('sso.callback'),
                'response_type' => 'code',
                'scope' => '',
            ]);

            return redirect(config('auth.sso.uri') . '/oauth/authorize?' . $query);
        }
        return $next($request);
    }
}
