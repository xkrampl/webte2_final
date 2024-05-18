<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\ExportDataController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\User\UserController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\UserMiddleware;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\AnswerController;

Route::get('/', function () {
    return inertia('Index/Index');
})->name('homepage');

Route::get('{question}', [QuestionController::class, 'show'])->name('question.show');
Route::get('{question}/results', [QuestionController::class, 'results'])->name('question.results.show');

Route::resource('question', QuestionController::class)->except(['index', 'show']);
Route::resource('question/{question}/answer', AnswerController::class)->only(['store']);

Route::put('question/{question}/active', [QuestionController::class, 'setActive'])
    ->middleware('auth')
    ->name('question.active');
Route::post('question/{question}/duplicate', [QuestionController::class, 'duplicate'])
    ->middleware('auth')
    ->name('question.duplicate');

// Auth
Route::group(['prefix' => 'auth'], function () {

    Route::get('login', [LoginController::class, 'create'])->name('login');
    Route::post('login', [LoginController::class, 'store'])->name('login.store');
    Route::delete('logout', [LoginController::class, 'destroy'])->name('login.destroy');

    Route::get('register', [RegisterController::class, 'create'])->name('register');
    Route::post('register', [RegisterController::class, 'store'])->name('register.store');

    Route::get('change-password', [ChangePasswordController::class, 'create'])
        ->name('change-password.create')
        ->middleware('auth');

    Route::post('change-password', [ChangePasswordController::class, 'store'])
        ->name('change-password.store')
        ->middleware('auth');

    Route::get('forgot-password', [ForgotPasswordController::class, 'create'])
        ->name('forgot-password.create')
        ->middleware('guest');
    Route::post('forgot-password', [ForgotPasswordController::class, 'store'])
        ->name('forgot-password.store')
        ->middleware('guest');

    Route::get('reset-password/{token}', [ResetPasswordController::class, 'create'])
        ->middleware('guest')
        ->name('password.reset');
    Route::post('reset-password', [ResetPasswordController::class, 'store'])
        ->middleware('guest')
        ->name('password.update');

});

// Admin
Route::group(['prefix' => 'admin', 'middleware' => ['auth', AdminMiddleware::class]], function () {
    Route::get('dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    Route::resource('question', \App\Http\Controllers\Admin\QuestionController::class)->only(['create', 'store'])->names('admin.question');
    Route::resource('user', \App\Http\Controllers\Admin\UserController::class)->except(['show'])->names('admin.user');
});

// User
Route::prefix('user')->name('user.')->middleware(['auth', 'verified', UserMiddleware::class])->group(function () {
    Route::get('dashboard', [UserController::class, 'index'])->name('dashboard');
});

// Export data
Route::get('data/export', ExportDataController::class)->name('data.export');

// Localization
Route::get('language/{language}', LanguageController::class)->name('language');
