<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NfaUserProfile;
use Illuminate\Support\Facades\Auth;

class NfaUserProfileController extends Controller
{
    public function show()
    {
        $profile = Auth::user()->profile;
        return view('nfauserprofile.show', compact('profile'));
    }
}
