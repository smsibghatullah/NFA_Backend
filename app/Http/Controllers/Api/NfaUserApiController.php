<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NfaUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\HasApiTokens;

class NfaUserApiController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'email'    => 'nullable|email|unique:nfa_users,email',
            'cnic'     => 'required|string|unique:nfa_users,cnic',
            'number'   => 'nullable|string',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        NfaUser::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'cnic'     => $request->cnic,
            'number'   => $request->number,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Registered successfully'
        ], 201);
    }
    public function login(Request $request)
{
    $request->validate([
        'login'    => 'required',   // email OR cnic
        'password' => 'required',
    ]);

    $user = NfaUser::where('email', $request->login)
            ->orWhere('cnic', $request->login)
            ->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json([
            'status' => false,
            'message' => 'Invalid credentials'
        ], 401);
    }

    if ($user->is_blocked) {
        return response()->json([
            'status' => false,
            'message' => 'Your account has been blocked'
        ], 403);
    }

    // 🔹 Generate Sanctum token
    $token = $user->createToken('nfa_user_token')->plainTextToken;

    return response()->json([
        'status' => true,
        'user' => [
            'id'     => $user->id,
            'name'   => $user->name,
            'email'  => $user->email,
            'cnic'   => $user->cnic,
        ],
        'token' => $token   // ye token Postman ya frontend me use hoga
    ]);
}
}
