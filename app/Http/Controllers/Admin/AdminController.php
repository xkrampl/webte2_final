<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\QuestionRequest;
use App\Models\Question;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->only(['created_at', 'subject', 'user']);

        return inertia('Admin/Index', [
            'questions' => Question::with(['answers', 'subject'])
                ->latest()
                ->filter($filters)
                ->get(),
            'filters' => $filters,
            'subjects' => Subject::orderBy('name', 'desc')->get(),
            'users' => User::orderByDesc('email')->get()
        ]);
    }
}
