<?php

use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\NewPasswordController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

Route::get('/', [WelcomeController::class, 'welcome'])->name('welcome');

Route::middleware('guest')->group(function (){
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);
    Route::get('/forgot-password', [ResetPasswordController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [ResetPasswordController::class, 'store'])->name('password.email');
    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.update');

    Route::get('/auth/google/redirect', [LoginController::class, 'authGoogleRedirect'])->name('auth.google.redirect');
    Route::get('/auth/google/callback', [LoginController::class, 'authGoogleCallback'])->name('auth.google.callback');
});

Route::middleware('auth')->group(function (){
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/email/verify', [EmailVerificationController::class, 'showVerificationNotice'])
        ->name('verification.notice');
    Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verifyEmail'])
        ->middleware('signed')
        ->name('verification.verify');
    Route::get('/email/verification-notification', [EmailVerificationController::class, 'sendEmailVerificationNotification'])
        ->middleware(['throttle:6,1'])
        ->name('verification.send');

    Route::get('/payment/{period}/create', [PaymentController::class, 'create'])->name('payment.create');
    Route::get('/payment/return/success', [PaymentController::class, 'confirm'])->name('payment.return.success');
    Route::get('/payment/return/cancel', [PaymentController::class, 'cancel'])->name('payment.return.cancel');
});

Route::middleware(['auth', 'verified', 'paid'])->group(function (){
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.dashboard');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/social-links/update', [ProfileController::class, 'updateUserSocialLinks'])
        ->name('profile.update-social-links');
    Route::post('/profile/address/update', [ProfileController::class, 'updateUserAddress'])
        ->name('profile.update-address');
    Route::post('/profile/avatar/upload', [ProfileController::class, 'storeAvatar'])
        ->name('profile.upload-avatar');
    Route::delete('/profile/avatar/delete', [ProfileController::class, 'destroyAvatar'])
        ->name('profile.delete-avatar');

    Route::get('/profile/generate-card', [ProfileController::class, 'generateCard'])->name('profile.generate-card');
});

Route::get('/pricing', [PaymentController::class, 'index'])->name('pricing');
Route::get('/links/{hash}', [ProfileController::class, 'page'])->name('user.page');
Route::get('/links/{hash}/download', [ProfileController::class, 'downloadVcard'])->name('user.vcard.download');

// URL::forceScheme('https');
