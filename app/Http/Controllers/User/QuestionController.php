<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index()
    {
        return inertia('User/Index', [
            'questions' => auth()->user()->questions()->latest()->withTrashed()->get()
        ]);
    }
}
