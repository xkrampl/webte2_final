<?php

use App\Http\Controllers\QuestionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return inertia('Index/Index');
});

Route::get('{question}', [QuestionController::class, 'show'])->name('question.show');
Route::get('{question}/results', [QuestionController::class, 'results']);

Route::resource('question', QuestionController::class)->except(['index', 'show']);
