<?php

use App\Http\Controllers\Auth\Admin;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
//    Route::get('register', [Admin\RegisteredUserController::class, 'create'])
//                ->name('register');

//    Route::post('register', [Admin\RegisteredUserController::class, 'store']);

    Route::get('login', [Admin\AuthenticatedSessionController::class, 'create'])
                ->name('login');

    Route::post('login', [Admin\AuthenticatedSessionController::class, 'store']);

//    Route::get('forgot-password', [Admin\PasswordResetLinkController::class, 'create'])
//                ->name('password.request');
//
//    Route::post('forgot-password', [Admin\PasswordResetLinkController::class, 'store'])
//                ->name('password.email');
//
//    Route::get('reset-password/{token}', [Admin\NewPasswordController::class, 'create'])
//                ->name('password.reset');
//
//    Route::post('reset-password', [Admin\NewPasswordController::class, 'store'])
//                ->name('password.update');
});

Route::middleware(['auth:admin'])->group(function () {
    Route::get('verify-email', [Admin\EmailVerificationPromptController::class, '__invoke'])
                ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', [Admin\VerifyEmailController::class, '__invoke'])
                ->middleware(['signed', 'throttle:6,1'])
                ->name('verification.verify');

    Route::post('email/verification-notification', [Admin\EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('verification.send');

    Route::get('confirm-password', [Admin\ConfirmablePasswordController::class, 'show'])
                ->name('password.confirm');

    Route::post('confirm-password', [Admin\ConfirmablePasswordController::class, 'store']);

    Route::post('logout', [Admin\AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');
});
