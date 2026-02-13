<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tender;

class TenderApiController extends Controller
{
    // GET: all tenders
    public function index(Request $request)
    {
        $this->validateApiKey($request);

        $tenders = Tender::latest()->get();

        return response()->json([
            'status' => true,
            'tenders' => $tenders->map(function($tender) {
                return [
                    'id' => $tender->id,
                    'title' => $tender->title,
                    'status' => $tender->status,
                    'file_url' => asset('uploads/tenders/' . $tender->file),
                    'created_at' => $tender->created_at->toDateTimeString(),
                ];
            })
        ]);
    }

    // GET: single tender
    public function show(Request $request, $id)
    {
        $this->validateApiKey($request);

        $tender = Tender::findOrFail($id);

        return response()->json([
            'status' => true,
            'data' => [
                'id' => $tender->id,
                'title' => $tender->title,
                'status' => $tender->status,
                'file_url' => asset('uploads/tenders/' . $tender->file),
                'created_at' => $tender->created_at->toDateTimeString(),
            ]
        ]);
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
