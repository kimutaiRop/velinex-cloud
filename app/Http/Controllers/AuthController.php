<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        try {
            $sessionIdBefore = $request->session()->getId();

            Log::channel('single')->debug('[LOGIN] attempt started', [
                'session_id_before' => $sessionIdBefore,
                'session_data'      => $request->session()->all(),
                'is_secure'         => $request->isSecure(),
                'scheme'            => $request->getScheme(),
                'host'              => $request->getHost(),
                'cookie_header'     => substr($request->header('Cookie', '(none)'), 0, 300),
                'ip'                => $request->ip(),
                'intended_url'      => session()->get('url.intended', '(not set)'),
            ]);

            $credentials = $request->validate([
                'login' => ['required', 'string', 'max:190'],
                'password' => ['required', 'string'],
            ]);

            $field = filter_var($credentials['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

            $attemptResult = Auth::attempt([$field => $credentials['login'], 'password' => $credentials['password']], false);

            Log::channel('single')->debug('[LOGIN] Auth::attempt result', [
                'field'          => $field,
                'login_value'    => $credentials['login'],
                'attempt_result' => $attemptResult,
                'auth_check'     => Auth::check(),
                'auth_user_id'   => Auth::id(),
            ]);

            if (!$attemptResult) {
                return back()->withErrors([
                    'login' => 'Login failed. Check your email/username and password.',
                ])->onlyInput('login');
            }

            $request->session()->regenerate();

            $sessionIdAfter  = $request->session()->getId();
            $intendedRoute   = route('dashboard');
            $intendedResolved = session()->get('url.intended', $intendedRoute);

            Log::channel('single')->debug('[LOGIN] after regenerate — about to redirect', [
                'session_id_before'  => $sessionIdBefore,
                'session_id_after'   => $sessionIdAfter,
                'session_data_after' => $request->session()->all(),
                'auth_check'         => Auth::check(),
                'auth_user_id'       => Auth::id(),
                'intended_resolved'  => $intendedResolved,
                'redirect_target'    => $intendedRoute,
            ]);

            return redirect()->intended($intendedRoute);
        } catch (Throwable $e) {
            Log::error('Login request failed', ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);

            return back()->withErrors([
                'login' => 'Something went wrong while signing in. Please try again.',
            ])->onlyInput('login');
        }
    }

    public function showRegister(): View
    {
        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'username' => ['required', 'string', 'max:40', 'regex:/^[a-zA-Z0-9._-]+$/', 'unique:users,username'],
            'client_name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:190', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $client = Client::firstOrCreate(
            ['slug' => Str::slug($validated['client_name'])],
            ['name' => $validated['client_name']]
        );

        $user = User::create([
            'name' => $validated['name'],
            'username' => strtolower($validated['username']),
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'client_id' => $client->id,
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}

