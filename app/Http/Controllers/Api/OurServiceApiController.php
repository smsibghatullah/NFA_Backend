<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OurService;

class OurServiceApiController extends Controller
{
    // ✅ Public view API (JSON only) with API key
    public function index(Request $request)
    {
        $this->validateApiKey($request);

        $services = OurService::latest()->get()->map(function ($service) {
            return [
                'id' => $service->id,
                'title' => $service->title,
                'content' => $service->content,
                'image' => $service->image ? asset('storage/' . $service->image) : null,
                'created_at' => $service->created_at
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $services
        ], 200);
    }

    // ✅ Single service view
    public function show(Request $request, $id)
    {
        $this->validateApiKey($request);

        $service = OurService::find($id);

        if (!$service) {
            return response()->json([
                'success' => false,
                'message' => 'Service not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $service->id,
                'title' => $service->title,
                'content' => $service->content,
                'image' => $service->image ? asset('storage/' . $service->image) : null,
                'created_at' => $service->created_at
            ]
        ], 200);
    }

    // ✅ Latest service
    public function latest(Request $request)
    {
        $this->validateApiKey($request);

        $service = OurService::latest()->first();

        if (!$service) {
            return response()->json([
                'success' => false,
                'message' => 'No service found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $service->id,
                'title' => $service->title,
                'content' => $service->content,
                'image' => $service->image ? asset('storage/' . $service->image) : null,
                'created_at' => $service->created_at
            ]
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
