<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->only(['created_at', 'subject']);

        return inertia('User/Index', [
            'questions' => auth()->user()->questions()
                ->with(['answers', 'subject'])
                ->filter($filters)
                ->published()
                ->latest()
                ->get(),
            'filters' => $filters
        ]);
    }
}
