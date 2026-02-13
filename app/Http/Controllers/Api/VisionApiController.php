<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vision;
use Illuminate\Http\Request;

class VisionApiController extends Controller
{
    // GET: latest Vision
    public function index(Request $request)
    {
        $this->validateApiKey($request);

        $vision = Vision::latest()->first();

        if (!$vision) {
            return response()->json([
                'success' => false,
                'message' => 'No vision record found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $vision
        ], 200);
    }

    // ✅ API key validation helper
     private function validateApiKey(Request $request)
{
    // Get key from query param or Authorization header
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
