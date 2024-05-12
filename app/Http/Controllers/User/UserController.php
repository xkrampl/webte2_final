<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->only(['created_at', 'subject']);

        return inertia('User/Index', [
            'questions' => auth()->user()->questions()
                ->with(['answers', 'subject'])
                ->filter($filters)
                ->latest()
                ->get(),
            'subjects' => Subject::orderBy('name', 'desc')->get(),
            'filters' => $filters
        ]);
    }
}
