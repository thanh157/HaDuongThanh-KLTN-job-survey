<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateSSO
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
//        return $next($request);
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
