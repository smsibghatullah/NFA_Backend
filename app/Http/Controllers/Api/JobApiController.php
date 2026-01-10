<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobListing;
use Validator;

class JobApiController extends Controller
{
    // ✅ Get all jobs
    public function index()
    {
        $jobs = JobListing::latest()->get();

        return response()->json([
            'status' => true,
            'message' => 'Job list fetched successfully',
            'data' => $jobs
        ], 200);
    }


    // ✅ Show single job
    public function show($id)
    {
        $job = JobListing::find($id);

        if (!$job) {
            return response()->json([
                'status' => false,
                'message' => 'Job not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $job
        ], 200);
    }

   

    // ✅ Delete job
    public function destroy($id)
    {
        $job = JobListing::find($id);

        if (!$job) {
            return response()->json([
                'status' => false,
                'message' => 'Job not found'
            ], 404);
        }

        $job->delete();

        return response()->json([
            'status' => true,
            'message' => 'Job deleted successfully'
        ], 200);
    }
}
