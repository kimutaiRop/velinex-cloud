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
        try {
            $cookieHeader = $request->header('Cookie', '');
            $cookieNames  = [];
            foreach (explode(';', $cookieHeader) as $part) {
                $part = trim($part);
                if (str_contains($part, '=')) {
                    $cookieNames[] = trim(explode('=', $part, 2)[0]);
                }
            }

            Log::channel('single')->debug('[AUTH-MIDDLEWARE] → ' . $request->method() . ' ' . $request->path(), [
                'session_id'         => $request->session()->getId(),
                'auth_check'         => Auth::check(),
                'auth_user_id'       => Auth::id(),
                'session_keys'       => array_keys($request->session()->all()),
                'cookie_names_sent'  => $cookieNames,
                'has_session_cookie' => in_array('laravel-session', $cookieNames),
            ]);
        } catch (\Throwable $e) {
            Log::channel('single')->error('[AUTH-MIDDLEWARE] exception in log middleware', [
                'error' => $e->getMessage(),
                'url'   => $request->path(),
            ]);
        }

        $response = $next($request);

        try {
            Log::channel('single')->debug('[AUTH-MIDDLEWARE] ← ' . $request->path(), [
                'status'      => $response->getStatusCode(),
                'location'    => $response->headers->get('Location'),
                'auth_check'  => Auth::check(),
            ]);
        } catch (\Throwable $e) {
        }

        return $response;
    }
}
