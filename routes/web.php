<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MailboxController;
use App\Http\Controllers\MailDomainController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login.attempt');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('auth.register');
    Route::post('/register', [AuthController::class, 'register'])->name('auth.register.store');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

    Route::prefix('dashboard/mail')->name('mail.')->group(function () {
        Route::get('/', [MailDomainController::class, 'index'])->name('domains.index');
        Route::get('/domains/create', [MailDomainController::class, 'create'])->name('domains.create');
        Route::post('/domains', [MailDomainController::class, 'store'])->name('domains.store');
        Route::get('/domains/{domain}', [MailDomainController::class, 'show'])->name('domains.show');
        Route::post('/domains/{domain}/verify', [MailDomainController::class, 'verify'])->name('domains.verify');
        Route::post('/domains/{domain}/mailboxes', [MailboxController::class, 'store'])->name('mailboxes.store');
        Route::post('/mailboxes/{mailbox}/password', [MailboxController::class, 'updatePassword'])->name('mailboxes.password');
        Route::post('/mailboxes/{mailbox}/toggle', [MailboxController::class, 'toggle'])->name('mailboxes.toggle');
    });
});
