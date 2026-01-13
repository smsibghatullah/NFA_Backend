<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;

class DocumentController extends Controller
{
    public function index()
    {
        return view('documents.adddocument');
    }

    public function store(Request $request)
    {
        $request->validate([
            'document_name' => 'required|string|max:255',
            'document_file' => 'required|mimes:pdf|max:2048',
        ]);

        $file = $request->file('document_file');
        $fileName = time().'_'.$file->getClientOriginalName();
        $file->move(public_path('uploads/documents'), $fileName);

        Document::create([
            'name' => $request->document_name,
            'file' => $fileName,
        ]);

        return redirect()->route('documents.show')->with('success', 'Document uploaded successfully');
    }

   public function show()
{
    $documents = Document::latest()->paginate(10);
    return view('documents.showdocument', compact('documents'));
}

    public function view($id)
    {
        $document = Document::findOrFail($id);
        return view('documents.viewdocument', compact('document'));
    }
    public function destroy($id)
{
    $document = Document::findOrFail($id);

    // delete file
    $filePath = public_path('uploads/documents/' . $document->file);
    if (file_exists($filePath)) {
        unlink($filePath);
    }

    // delete record
    $document->delete();

    return redirect()->route('documents.show')
        ->with('success', 'Document deleted successfully');
}

}
