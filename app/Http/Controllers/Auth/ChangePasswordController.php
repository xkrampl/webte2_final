<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    public function create()
    {
        return inertia('Auth/ChangePassword');
    }

    public function store(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password'     => 'required|confirmed|min:8|string'
        ]);

        $auth = Auth::user();

        if (!Hash::check($request->get('current_password'), $auth->password)) {
            return redirect()->back()->with('error', __('The current password is invalid.'));
        }

        if (strcmp($request->get('current_password'), $request->new_password) == 0) {
            return redirect()->back()->with('error', __('The new password must not be the same as the current password.'));
        }

        $user = User::find($auth->id);
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->back()->with('success', __('Password changed successfully.'));
    }
}
