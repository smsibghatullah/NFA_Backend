<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobListing;
use App\Models\NfaUser;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class EligibilityApiController extends Controller
{
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
                'message' => 'Profile not found. Please complete your profile first.'
            ], 400);
        }

        // ✅ Job ID from request body
        $jobId = $request->input('job_id');
        if (!$jobId) {
            return response()->json([
                'status' => false,
                'message' => 'Job ID is required.'
            ], 400);
        }

        $job = JobListing::find($jobId);
        if (!$job) {
            return response()->json([
                'status' => false,
                'message' => 'Job not found.'
            ], 404);
        }

        $errors = [];

        // ===== Education Check =====
        if ($job->required_education) {
            $degreeHierarchy = [
                'matric' => 1,
                'intermediate' => 2,
                'bachelors' => 3,
                'masters' => 4,
            ];

            $requiredLevel = $degreeHierarchy[strtolower($job->required_education)] ?? 0;

            // Check if user has at least required level
            $hasEducation = $profile->educations->contains(function ($edu) use ($degreeHierarchy, $requiredLevel) {
                $userLevel = $degreeHierarchy[strtolower($edu->degree)] ?? 0;
                return $userLevel >= $requiredLevel;
            });

            if (!$hasEducation) {
                $errors[] = "You do not meet the required education: {$job->required_education}.";
            }
        }

        // ===== Experience Check =====
        if ($job->required_experience && $job->required_experience !== 'false') {
            $totalExperienceMonths = 0;

            foreach ($profile->workHistories as $work) {
                $start = Carbon::parse($work->start_date);
                $end = $work->end_date ? Carbon::parse($work->end_date) : Carbon::now();
                $totalExperienceMonths += $start->diffInMonths($end);
            }

            $requiredMonths = (int) $job->required_experience;
            if ($totalExperienceMonths < $requiredMonths) {
                $years = floor($totalExperienceMonths / 12);
                $months = $totalExperienceMonths % 12;
                $errors[] = "You have {$years} years and {$months} months experience. Required: " . floor($requiredMonths / 12) . " years.";
            }
        }

        // ===== Result =====
        if (count($errors) > 0) {
            return response()->json([
                'status' => false,
                'eligible' => false,
                'reasons' => $errors
            ], 200);
        }

        return response()->json([
            'status' => true,
            'eligible' => true,
            'message' => 'You are eligible for this job.'
        ], 200);
    }
}
