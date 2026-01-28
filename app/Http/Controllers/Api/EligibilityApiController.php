<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobListing;
use App\Models\NfaUser;
use App\Models\NfaUserProfile;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class EligibilityApiController extends Controller
{
    private function getEducationLevel($degree)
    {
        $degree = strtolower($degree);

        if (str_contains($degree, 'phd')) {
            return 5;
        }

        if (str_contains($degree, 'master') || str_contains($degree, 'ms') || str_contains($degree, 'msc')) {
            return 4;
        }

        if (
            str_contains($degree, 'bachelor') ||
            str_contains($degree, 'bs') ||
            str_contains($degree, 'bsc') ||
            str_contains($degree, 'ba')
        ) {
            return 3;
        }

        if (str_contains($degree, 'intermediate') || str_contains($degree, 'inter')) {
            return 2;
        }

        if (str_contains($degree, 'matric')) {
            return 1;
        }

        return 0;
    }

    public function checkEligibility(Request $request)
    {
        $authUser = Auth::user(); // default User model

        $nfaUser = NfaUser::find($authUser->id);

        $profile = $nfaUser?->profile()
            ->with('educations', 'workHistories')
            ->first();

        if (!$profile) {
            return response()->json([
                'status' => false,
                'message' => 'Profile not found'
            ], 400);
        }

        $job = JobListing::find($request->job_id);
        if (!$job) {
            return response()->json([
                'status' => false,
                'message' => 'Job not found'
            ], 404);
        }

        $errors = [];

        /* =======================
       🎓 EDUCATION CHECK
    ========================*/

        $educationOrder = [
            'matric'        => 1,
            'intermediate'  => 2,
            'bachelors'     => 3,
            'masters'       => 4,
            'phd'           => 5,
        ];

        if ($job->required_education) {

            $requiredLevel = $this->getEducationLevel($job->required_education);
            $userHighestLevel = 0;

            foreach ($profile->educations as $edu) {
                $level = $this->getEducationLevel($edu->degree);
                if ($level > $userHighestLevel) {
                    $userHighestLevel = $level;
                }
            }

            if ($userHighestLevel < $requiredLevel) {
                $errors[] = "Required education: {$job->required_education}. You do not meet this requirement.";
            }
        }

        /* =======================
       🎂 AGE / DOB CHECK
    ========================*/

        if ($job->min_age || $job->max_age) {

            $age = Carbon::parse($profile->date_of_birth)->age;

            if ($job->min_age && $age < $job->min_age) {
                $errors[] = "Minimum age required is {$job->min_age}. Your age is {$age}.";
            }

            if ($job->max_age && $age > $job->max_age) {
                $errors[] = "Maximum age allowed is {$job->max_age}. Your age is {$age}.";
            }
        }

        /* =======================
       💼 EXPERIENCE CHECK
    ========================*/

        if ($job->required_experience) {

            $totalMonths = 0;

            foreach ($profile->workHistories as $work) {

                if (!$work->start_date) {
                    continue;
                }

                $start = Carbon::parse($work->start_date);

                // Agar currently working hai OR end_date null
                if ($work->currently_working || !$work->end_date) {
                    $end = Carbon::now();
                } else {
                    $end = Carbon::parse($work->end_date);
                }

                if ($end->greaterThan($start)) {
                    $totalMonths += $start->diffInMonths($end);
                }
            }

            if ($totalMonths < $job->required_experience) {

                $years  = intdiv($totalMonths, 12);
                $months = $totalMonths % 12;

                $reqYears = intdiv($job->required_experience, 12);

                $errors[] = "Required experience: {$reqYears} years. You have {$years} years {$months} months.";
            }
        }

        /* =======================
       ✅ FINAL RESPONSE
    ========================*/

        if (!empty($errors)) {
            return response()->json([
                'status'   => false,
                'eligible' => false,
                'reasons'  => $errors
            ]);
        }

        return response()->json([
            'status'   => true,
            'eligible' => true,
            'message'  => 'You are eligible for this job'
        ]);
    }
}
