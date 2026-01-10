<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobApplication;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class JobApplicationApiController extends Controller
{
    public function myApplications()
{
    $user = Auth::user();

    $applications = JobApplication::with('job') // job relation
        ->where('user_id', $user->id)
        ->latest()
        ->get()
        ->map(function ($app) {
            return [
                'id' => $app->id,
                'job_id' => $app->job_id,
                'job_title' => $app->job?->job_title ?? null,
                'applied_at' => $app->created_at->format('Y-m-d'),

                'cv' => $app->cv ? Storage::url($app->cv) : null,
                'degree' => $app->degree ? Storage::url($app->degree) : null,
                'cnic' => $app->cnic ? Storage::url($app->cnic) : null,
            ];
        });

    return response()->json([
        'status' => true,
        'data' => $applications
    ]);
}
    public function submit(Request $request)
    {
        // ✅ Validate request
        $request->validate([
            'job_id' => 'required|exists:job_listings,id',
            'cv' => 'required|file|mimes:pdf,doc,docx|max:2048',
            'degree' => 'required|file|mimes:pdf,doc,docx|max:2048',
            'cnic' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $user = Auth::user();

        // ✅ Upload files in public storage
        $cvPath = $request->file('cv')->store('applications/cv', 'public');
$degreePath = $request->file('degree')->store('applications/degree', 'public');
$cnicPath = $request->file('cnic')->store('applications/cnic', 'public');


        // ✅ Save application
        $application = JobApplication::create([
            'user_id' => $user->id,
            'job_id' => $request->job_id,
            'cv' => $cvPath,
            'degree' => $degreePath,
            'cnic' => $cnicPath,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Application submitted successfully!',
            'data' => [
                'cv_url' => Storage::url($cvPath),
                'degree_url' => Storage::url($degreePath),
                'cnic_url' => Storage::url($cnicPath),
            ]
        ]);
    }
}
