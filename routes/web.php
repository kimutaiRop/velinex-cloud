<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MailboxController;
use App\Http\Controllers\MailDomainController;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashbaord', fn () => redirect()->route('dashboard'));

Route::middleware('guest')->group(function () {
    Route::get('/login', function () use (&$__router) {
        Log::channel('single')->debug('[GUEST /login] reached login page (auth middleware passed as guest)', [
            'session_id' => session()->getId(),
            'auth_check' => auth()->check(),
            'user_id'    => auth()->id(),
            'session_keys' => array_keys(session()->all()),
        ]);
        return app(\App\Http\Controllers\AuthController::class)->showLogin();
    })->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login.attempt');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('auth.register');
    Route::post('/register', [AuthController::class, 'register'])->name('auth.register.store');
});

Route::middleware(['log.auth', 'auth'])->group(function () {
    Route::get('/dashboard', function () {
        Log::channel('single')->debug('[DASHBOARD] /dashboard hit — auth passed, redirecting to mail.dashboard', [
            'session_id' => session()->getId(),
            'user_id'    => auth()->id(),
        ]);
        return redirect()->route('mail.dashboard');
    })->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

    Route::prefix('dashboard/mail')->name('mail.')->group(function () {
        Route::get('/', [MailDomainController::class, 'index'])->name('dashboard');
        Route::get('/domains', [MailDomainController::class, 'manage'])->name('domains.manage');
        Route::get('/domains/recent', [MailDomainController::class, 'index'])->name('domains.index');
        Route::get('/domains/create', [MailDomainController::class, 'create'])->name('domains.create');
        Route::post('/domains', [MailDomainController::class, 'store'])->name('domains.store');
        Route::get('/domains/{domain}', [MailDomainController::class, 'show'])->name('domains.show');
        Route::get('/domains/{domain}/mailboxes', [MailDomainController::class, 'mailboxes'])->name('domains.mailboxes');
        Route::post('/domains/{domain}/verify', [MailDomainController::class, 'verify'])->name('domains.verify');
        Route::post('/domains/{domain}/toggle', [MailDomainController::class, 'toggleDomain'])->name('domains.toggle');
        Route::delete('/domains/{domain}', [MailDomainController::class, 'destroy'])->name('domains.destroy');
        Route::post('/domains/{domain}/mailboxes', [MailboxController::class, 'store'])->name('mailboxes.store');
        Route::post('/mailboxes/{mailbox}/password', [MailboxController::class, 'updatePassword'])->name('mailboxes.password');
        Route::post('/mailboxes/{mailbox}/toggle', [MailboxController::class, 'toggle'])->name('mailboxes.toggle');
    });
});
