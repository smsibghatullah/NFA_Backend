<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GeneralInfo;

class GeneralInfoApiController extends Controller
{
    // ✅ Latest general info with API key security
    public function latest(Request $request)
    {
        $this->validateApiKey($request);

        $info = GeneralInfo::where('is_visible', 1)
            ->latest()
            ->first();

        if (!$info) {
            return response()->json([
                'success' => false,
                'message' => 'No general information found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'email' => $info->email,
                'phone' => $info->phone,
                'address' => $info->address,
                'facebook' => $info->facebook,
                'twitter' => $info->twitter,
                'instagram' => $info->instagram,
            ]
        ], 200);
    }

    // ✅ API key validation helper
    private function validateApiKey(Request $request)
    {
        // Get key from query param OR Authorization header
        $key = $request->query('api_key') 
               ?? str_replace('Bearer ', '', $request->header('Authorization'));

        if (!$key || $key !== env('GENERAL_API_KEY')) {
            abort(response()->json([
                'status' => false,
                'message' => 'Unauthorized: Invalid API key'
            ], 401));
        }
    }
}
