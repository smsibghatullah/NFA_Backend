<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Candidate;

class CandidatesApiController extends Controller
{
    /**
     * Public API: fetch candidate securely with GENERAL_API_KEY
     */
    public function getCandidateByCnic(Request $request)
{
    // Validate CNIC & API key
    $request->validate([
        'cnic' => 'required|string',
        'api_key' => 'required|string',
    ]);

    // Check GENERAL_API_KEY
    if ($request->api_key !== env('GENERAL_API_KEY')) {
        return response()->json([
            'success' => false,
            'message' => 'Unauthorized: Invalid API key'
        ], 401);
    }

    // Clean the CNIC (remove non-digits)
    $rawCnic = preg_replace('/\D/', '', $request->cnic);

    if (strlen($rawCnic) !== 13) {
        return response()->json([
            'success' => false,
            'message' => 'CNIC must be 13 digits'
        ], 400);
    }

    // Add dashes in correct positions: 5-7-1
    $formattedCnic = substr($rawCnic, 0, 5) . '-' .
                     substr($rawCnic, 5, 7) . '-' .
                     substr($rawCnic, 12, 1);

    // Find candidate by formatted CNIC
    $candidate = Candidate::where('cnic', $formattedCnic)->first();

    if (!$candidate) {
        return response()->json([
            'success' => false,
            'message' => 'Candidate not found'
        ], 404);
    }

    // Return only necessary fields
    return response()->json([
        'success' => true,
        'data' => [
            'sr_no' => $candidate->sr_no,
            'roll_no' => $candidate->roll_no,
            'name' => $candidate->name,
            'mobile_no' => $candidate->mobile_no,
            'paper' => $candidate->paper,
            'test_date' => $candidate->test_date,
            'session' => $candidate->session,
            'reporting_time' => $candidate->reporting_time,
            'conduct_time' => $candidate->conduct_time,
            'venue' => $candidate->venue,
        ]
    ]);
}

}
