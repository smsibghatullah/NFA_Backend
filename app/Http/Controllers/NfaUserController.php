<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NfaUser;

class NfaUserController extends Controller
{
    public function index()
    {
        // Fetch all users with their profile, educations and work histories
        $users = NfaUser::with('profile.educations', 'profile.workHistories')->paginate(10);

        return view('nfa_users.showusers', compact('users'));
    }

    public function block($id)
    {
        $user = NfaUser::findOrFail($id);
        $user->is_blocked = true;
        $user->blocked_at = now();
        $user->save();

        return back()->with('success', 'User blocked successfully.');
    }

    public function unblock($id)
    {
        $user = NfaUser::findOrFail($id);
        $user->is_blocked = false;
        $user->blocked_at = null;
        $user->save();

        return back()->with('success', 'User unblocked successfully.');
    }
}
