<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NfaUser;
use Illuminate\Http\Request;
use App\Models\NfaUserProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class NfaUserProfileApiController extends Controller
{
    // 🔹 Create or Update Profile
    public function saveProfile(Request $request)
    {
        $user = Auth::user(); // Logged-in NFA user

        $validator = Validator::make($request->all(), [
            'date_of_birth'   => 'required|date',
            'postal_address'  => 'required|string',
            'phone_number'    => 'required|string|max:15',
            'bio'             => 'nullable|string',
            'educations'      => 'nullable|array',
            'work_histories'  => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return response()->json(['status'=>false,'errors'=>$validator->errors()],422);
        }

        $profile = NfaUserProfile::updateOrCreate(
            ['nfa_user_id' => $user->id],
            $request->only(['date_of_birth','postal_address','phone_number','bio'])
        );

        // Optional: Save educations and work histories (overwrite)
        if($request->has('educations')){
            $profile->educations()->delete();
            foreach($request->educations as $edu){
                $profile->educations()->create($edu);
            }
        }

        if($request->has('work_histories')){
            $profile->workHistories()->delete();
            foreach($request->work_histories as $work){
                $profile->workHistories()->create($work);
            }
        }

return response()->json([
    'status' => true,
    'profile' => $profile->load([
        'educations',
        'workHistories',
        'user:id,email,name'
    ])
]);    }

    // 🔹 Show Profile

public function showProfile()
{
    $authUser = Auth::user(); // default User model

    $nfaUser = NfaUser::find($authUser->id);

    $profile = $nfaUser?->profile()
->with([
            'educations',
            'workHistories',
            'user:id,email,name' // ✅ add this line
        ])        ->first();

    return response()->json([
        'status' => true,
        'profile' => $profile
    ]);
}

}
