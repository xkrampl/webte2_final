<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\QuestionRequest;
use App\Models\Question;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    public function index()
    {
        return inertia('Admin/User/Index', [
            'users' => User::with(['questions'])->orderByDesc('email')->get()
        ]);
    }

    public function create()
    {
        return inertia('Admin/User/Create');
    }

    public function store(Request $request)
    {
        return redirect()
            ->route('user.index')
            ->with('success', __('You have created a new user.'));
    }

    public function edit(User $user)
    {
        return inertia('Admin/User/Edit', [
            'user' => $user,
        ]);
    }

    public function update(Request $request, User $user)
    {
        return redirect()->back()->with('success', __('You have modified the user.'));
    }

    public function destroy(User $user)
    {
        $user->deleteOrFail();
        return redirect()->back()->with('success', __('You have successfully deleted the user.'));
    }
}
