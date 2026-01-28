<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NfaUserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class NfaUserProfileApiController extends Controller
{
    /**
     * 🔹 Create / Update Profile
     */
    public function saveProfile(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        /**
         * 🔁 Normalize JSON FormData fields
         */
        $input = $request->all();

        foreach (['educations', 'work_histories', 'skills', 'hobbies'] as $field) {
            if ($request->has($field) && is_string($request->$field)) {
                $decoded = json_decode($request->$field, true);
                $input[$field] = is_array($decoded) ? array_values($decoded) : [];
            }
        }

        $request->replace($input);

        /**
         * ✅ Validation
         */
        $validator = Validator::make($request->all(), [

            // Personal Info
            'first_name'         => 'required|string|max:100',
            'last_name'          => 'required|string|max:100',
            'cnic'               => 'required|string|max:20',
            'father_name'        => 'required|string|max:100',
            'gender'             => 'required|in:male,female,other',
            'marital_status'     => 'required|in:single,married',
            'permanent_address'  => 'required|string|max:255',
            'current_address'    => 'required|string|max:255',
            'postal_address'     => 'required|string|max:255',
            'phone_number'       => 'required|regex:/^03[0-9]{9}$/',
            'domicile_city'      => 'required|string|max:100',
            'domicile_province'  => 'required|string|max:100',
            'religion'           => 'required|string|max:50',
            'nationality'        => 'required|string|max:50',
            'current_occupation' => 'required|string|max:100',
            'date_of_birth'      => 'required|date|before:today',
            'bio'                => 'nullable|string|max:1000',
            'profile_picture'    => 'nullable|image|max:2048',

            // Educations
            'educations'                     => 'nullable|array',
            'educations.*.institution_name'  => 'required_with:educations|string|max:255',
            'educations.*.degree'            => 'required_with:educations|string|max:100',
            'educations.*.field_of_study'    => 'required_with:educations|string|max:150',
            'educations.*.start_date'        => 'required_with:educations|date',
            'educations.*.end_date'          => 'nullable|date|after_or_equal:educations.*.start_date',

            // Work Histories
            'work_histories'                     => 'nullable|array',
            'work_histories.*.company_name'      => 'required_with:work_histories|string|max:255',
            'work_histories.*.job_title'         => 'required_with:work_histories|string|max:150',
            'work_histories.*.start_date'        => 'required_with:work_histories|date',
            'work_histories.*.end_date'          => 'nullable|date|after_or_equal:work_histories.*.start_date',
            'work_histories.*.responsibilities'  => 'nullable|string|max:1500',
            'work_histories.*.currently_working' => 'boolean',

            // Skills
            'skills'               => 'nullable|array',
            'skills.*.name'        => 'required_with:skills|string|max:100',
            'skills.*.description' => 'nullable|string|max:500',

            // Hobbies
            'hobbies'               => 'nullable|array',
            'hobbies.*.name'        => 'required_with:hobbies|string|max:100',
            'hobbies.*.description' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        DB::beginTransaction();

        try {

            /**
             * 🔍 Existing profile (for edit)
             */
            $existingProfile = NfaUserProfile::where('nfa_user_id', $user->id)->first();

            /**
             * 📸 Profile Picture Upload + Old Delete
             */
            $profilePicturePath = $existingProfile->profile_picture ?? null;

            if ($request->hasFile('profile_picture')) {

                if ($existingProfile && $existingProfile->profile_picture) {
                    Storage::disk('public')->delete($existingProfile->profile_picture);
                }

                $profilePicturePath = $request->file('profile_picture')
                    ->store('profiles', 'public');
            }

            /**
             * ✅ Save / Update Profile
             */
            $profile = NfaUserProfile::updateOrCreate(
                ['nfa_user_id' => $user->id],
                [
                    'first_name'         => $request->first_name,
                    'last_name'          => $request->last_name,
                    'cnic'               => $request->cnic,
                    'father_name'        => $request->father_name,
                    'gender'             => $request->gender,
                    'marital_status'     => $request->marital_status,
                    'permanent_address'  => $request->permanent_address,
                    'current_address'    => $request->current_address,
                    'postal_code'        => $request->postal_address,
                    'phone_number'       => $request->phone_number,
                    'domicile_city'      => $request->domicile_city,
                    'domicile_province'  => $request->domicile_province,
                    'religion'           => $request->religion,
                    'nationality'        => $request->nationality,
                    'current_occupation' => $request->current_occupation,
                    'date_of_birth'      => $request->date_of_birth,
                    'bio'                => $request->bio,
                    'profile_picture'    => $profilePicturePath,
                ]
            );

            /**
             * 🔁 Sync Relations
             */
            $profile->educations()->delete();
            foreach ($request->educations ?? [] as $edu) {
                $profile->educations()->create($edu);
            }

            $profile->workHistories()->delete();
            foreach ($request->work_histories ?? [] as $work) {

                if (empty($work['company_name']) || empty($work['job_title'])) {
                    continue;
                }

                $profile->workHistories()->create([
                    'company_name'      => $work['company_name'],
                    'job_title'         => $work['job_title'],
                    'start_date'        => $work['start_date'],
                    'end_date'          => ($work['currently_working'] ?? false)
                                            ? null
                                            : ($work['end_date'] ?? null),
                    'responsibilities'  => $work['responsibilities'] ?? null,
                    'currently_working' => $work['currently_working'] ?? false,
                ]);
            }

            $profile->skills()->delete();
            foreach ($request->skills ?? [] as $skill) {
                $profile->skills()->create($skill);
            }

            $profile->hobbies()->delete();
            foreach ($request->hobbies ?? [] as $hobby) {
                $profile->hobbies()->create($hobby);
            }

            DB::commit();

            return response()->json([
                'status'  => true,
                'message' => 'Profile saved successfully',
                'profile' => $profile->load([
                    'educations',
                    'workHistories',
                    'skills',
                    'hobbies',
                    'user:id,name,email'
                ])
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * 🔹 Show Profile
     */
    public function showProfile()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        $profile = NfaUserProfile::with([
            'educations',
            'workHistories',
            'skills',
            'hobbies',
            'user:id,name,email'
        ])->where('nfa_user_id', $user->id)->first();

        return response()->json([
            'status'  => true,
            'profile' => $profile
        ]);
    }
}
