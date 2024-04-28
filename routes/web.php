<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return inertia('Index/Index');
});

Route::get('/votes', function () {
    return inertia('Votes/Index', ['message' => 'Hello message']);
});

