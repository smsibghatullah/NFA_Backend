<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Document;

class DocumentApiController extends Controller
{
    // ✅ List documents with API key check
    public function index(Request $request)
    {
        $this->validateApiKey($request);

        $documents = Document::latest()->get()->map(function ($doc) {
            return [
                'id' => $doc->id,
                'name' => $doc->name,
                'file' => $doc->file,
                'file_url' => asset('uploads/documents/' . $doc->file),
                'created_at' => $doc->created_at,
            ];
        });

        return response()->json([
            'status' => true,
            'documents' => $documents
        ]);
    }

    // ✅ Store document with API key check
    public function store(Request $request)
    {
        $this->validateApiKey($request);

        $request->validate([
            'name' => 'required|string|max:255',
            'file' => 'required|mimes:pdf|max:2048',
        ]);

        $file = $request->file('file');
        $fileName = time().'_'.$file->getClientOriginalName();
        $file->move(public_path('uploads/documents'), $fileName);

        $doc = Document::create([
            'name' => $request->name,
            'file' => $fileName
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Document uploaded successfully',
            'document' => $doc
        ], 201);
    }

    // ✅ Show single document with API key check
    public function show(Request $request, $id)
    {
        $this->validateApiKey($request);

        $doc = Document::findOrFail($id);

        return response()->json([
            'status' => true,
            'document' => $doc,
            'file_url' => asset('uploads/documents/'.$doc->file)
        ]);
    }

    // ✅ API key validation helper
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
