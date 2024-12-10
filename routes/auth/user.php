<?php

use App\Http\Controllers\Auth\User;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('register', [User\RegisteredUserController::class, 'create'])
                ->name('register');

    Route::post('register', [User\RegisteredUserController::class, 'store']);

    Route::get('login', [User\AuthenticatedSessionController::class, 'create'])
                ->name('login');

    Route::post('login', [User\AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [User\PasswordResetLinkController::class, 'create'])
                ->name('password.request');

    Route::post('forgot-password', [User\PasswordResetLinkController::class, 'store'])
                ->name('password.email');

    Route::get('reset-password/{token}', [User\NewPasswordController::class, 'create'])
                ->name('password.reset');

    Route::post('reset-password', [User\NewPasswordController::class, 'store'])
                ->name('password.update');
});

Route::middleware(['web', 'auth:user'])->group(function () {
    Route::get('verify-email', [User\EmailVerificationPromptController::class, '__invoke'])
                ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', [User\VerifyEmailController::class, '__invoke'])
                ->middleware(['signed', 'throttle:6,1'])
                ->name('verification.verify');

    Route::post('email/verification-notification', [User\EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('verification.send');

    Route::get('confirm-password', [User\ConfirmablePasswordController::class, 'show'])
                ->name('password.confirm');

    Route::post('confirm-password', [User\ConfirmablePasswordController::class, 'store']);

    Route::post('logout', [User\AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');
});
