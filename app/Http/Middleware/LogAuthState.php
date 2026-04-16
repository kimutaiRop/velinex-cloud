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

        // Parse individual cookies from header for easier reading
        $cookies = [];
        foreach (explode(';', $cookieHeader) as $part) {
            $part = trim($part);
            if (str_contains($part, '=')) {
                [$name] = explode('=', $part, 2);
                $cookies[] = trim($name);
            }
        }

        Log::channel('single')->debug('[AUTH-MIDDLEWARE] → incoming request', [
            'url'             => $request->fullUrl(),
            'method'          => $request->method(),
            'is_secure'       => $isSecure,
            'session_id'      => $sessionId,
            'session_started' => $sessionExists,
            'auth_check'      => $isAuth,
            'auth_user_id'    => $userId,
            'session_keys'    => array_keys($sessionAll),
            'has_login_key'   => collect($sessionAll)->keys()->contains(fn ($k) => str_starts_with($k, 'login_')),
            'cookie_names_sent' => $cookies,           // which cookie names the browser sent
            'has_session_cookie' => in_array('laravel-session', $cookies),
            'session_data'    => $sessionAll,           // full session contents
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
