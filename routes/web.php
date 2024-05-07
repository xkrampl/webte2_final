<?php

use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\QuestionController;
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
Route::put('question/{question}/close-voting', [QuestionController::class, 'closeVoting'])
    ->middleware('auth')
    ->name('question.close');

// Auth
Route::group(['prefix' => 'auth'], function () {

    Route::get('login', [LoginController::class, 'create'])->name('login.create');
    Route::post('login', [LoginController::class, 'store'])->name('login.store');
    Route::delete('logout', [LoginController::class, 'destroy'])->name('login.destroy');

    Route::get('register', [RegisterController::class, 'create'])->name('register.create');
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
Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth', 'admin']], function () {

});

// User
Route::prefix('user')->name('user.')->middleware(['auth', 'verified'])->group(function () {
    Route::resource('question', \App\Http\Controllers\User\QuestionController::class)
        ->only(['index']);
});

// Export data
Route::get('data/export', \App\Http\Controllers\ExportDataController::class)->name('data.export');
