<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Document;

class DocumentApiController extends Controller
{
  public function index()
{
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


    public function store(Request $request)
    {
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

    public function show($id)
    {
        $doc = Document::findOrFail($id);

        return response()->json([
            'status' => true,
            'document' => $doc,
            'file_url' => asset('uploads/documents/'.$doc->file)
        ]);
    }
}
