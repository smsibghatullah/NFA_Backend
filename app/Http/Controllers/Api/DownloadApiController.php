<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Download;

class DownloadApiController extends Controller
{
    // ✅ GET: all downloads
    public function index(Request $request)
    {
        $this->validateApiKey($request);

        $downloads = Download::latest()->get()->map(function ($download) {
            return [
                'id' => $download->id,
                'name' => $download->name,
                'file' => $download->file,
                'file_url' => asset('uploads/downloads/' . $download->file),
                'created_at' => $download->created_at,
            ];
        });

        return response()->json([
            'status' => true,
            'downloads' => $downloads
        ]);
    }

    // ✅ POST: upload download PDF
    public function store(Request $request)
    {
        $this->validateApiKey($request);

        $request->validate([
            'name' => 'required|string|max:255',
            'file' => 'required|mimes:pdf|max:2048',
        ]);

        $file = $request->file('file');
        $fileName = time().'_'.$file->getClientOriginalName();
        $file->move(public_path('uploads/downloads'), $fileName);

        $download = Download::create([
            'name' => $request->name,
            'file' => $fileName
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Download uploaded successfully',
            'data' => $download
        ], 201);
    }

    // ✅ GET: single download
    public function show(Request $request, $id)
    {
        $this->validateApiKey($request);

        $download = Download::findOrFail($id);

        return response()->json([
            'status' => true,
            'data' => $download,
            'file_url' => asset('uploads/downloads/'.$download->file)
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
