<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\QuestionRequest;
use App\Models\Question;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

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
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return redirect()
            ->route('admin.user.index')
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
        $rules = [
            'name' => 'required|string|max:255',
            'is_admin' => 'required|boolean'
        ];

        if ($request->email !== $request->user->email) {
            $rules['email'] = 'required|email|unique:users,email';
        }

        if ($request->filled('password')) {
            $rules['password'] = 'required|min:8';
        }

        $data = $request->validate($rules);
        $user->update($data);

        return redirect()->route('admin.user.index')->with('success', __('You have modified the user.'));
    }

    public function destroy(User $user)
    {
        $user->deleteOrFail();
        return redirect()->back()->with('success', __('You have successfully deleted the user.'));
    }
}
