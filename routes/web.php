<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\QuestionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return inertia('Index/Index');
})->name('homepage');

Route::get('{question}', [QuestionController::class, 'show'])->name('question.show');
Route::get('{question}/results', [QuestionController::class, 'results']);

Route::resource('question', QuestionController::class)->except(['index', 'show']);

// Auth
Route::group(['prefix' => 'auth'], function () {
    Route::resource('login', LoginController::class)->only(['create', 'store']);
    Route::resource('register', RegisterController::class)->only(['create', 'store']);
    Route::resource('forgot-password', ForgotPasswordController::class)
        ->only(['create', 'store'])
        ->middleware('guest');

    Route::get('reset-password/{token}', [ResetPasswordController::class, 'create'])
        ->middleware('guest')
        ->name('password.reset');
    Route::post('reset-password', [ResetPasswordController::class, 'store'])
        ->middleware('guest')
        ->name('password.update');
});
