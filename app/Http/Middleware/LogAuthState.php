<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class LogAuthState
{
    public function handle(Request $request, Closure $next): Response
    {
        $sessionId     = $request->session()->getId();
        $sessionExists = $request->session()->isStarted();
        $sessionAll    = $request->session()->all();
        $cookieHeader  = $request->header('Cookie', '(none)');
        $isSecure      = $request->isSecure();
        $isAuth        = Auth::check();
        $userId        = Auth::id();

        Log::channel('single')->debug('[AUTH-MIDDLEWARE] → incoming request', [
            'url'            => $request->fullUrl(),
            'method'         => $request->method(),
            'is_secure'      => $isSecure,
            'session_id'     => $sessionId,
            'session_started'=> $sessionExists,
            'auth_check'     => $isAuth,
            'auth_user_id'   => $userId,
            'session_keys'   => array_keys($sessionAll),
            'has_login_key'  => collect($sessionAll)->keys()->contains(fn ($k) => str_starts_with($k, 'login_')),
            'cookie_header'  => substr($cookieHeader, 0, 200),
        ]);

        $response = $next($request);

        Log::channel('single')->debug('[AUTH-MIDDLEWARE] ← response', [
            'url'         => $request->fullUrl(),
            'status'      => $response->getStatusCode(),
            'location'    => $response->headers->get('Location'),
            'session_id'  => $request->session()->getId(),
            'auth_check'  => Auth::check(),
            'auth_user_id'=> Auth::id(),
        ]);

        return $response;
    }
}
