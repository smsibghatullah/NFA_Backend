<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OurService;

class OurServiceApiController extends Controller
{
    // ✅ Public view API (JSON only)
  public function index()
{
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
    public function show($id)
    {
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
    public function latest()
    {
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
}
