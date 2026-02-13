<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Download;
use Illuminate\Support\Str;

class DownloadSectionController extends Controller
{
    public function index()
    {
        return view('downloadsection.adddownload');
    }

    public function store(Request $request)
    {
        $request->validate([
            'download_name' => 'required|string',
            'download_file' => 'required|mimes:pdf,doc,docx',
        ]);

        $file = $request->file('download_file');

        // Keep original filename (spaces, special chars)
        $fileName = $file->getClientOriginalName();

        // Avoid overwriting: check if file exists, append random string if needed
        $destinationPath = public_path('uploads/downloads');
        if (file_exists($destinationPath.'/'.$fileName)) {
            $fileName = pathinfo($fileName, PATHINFO_FILENAME)
                        .'_'.Str::random(5)
                        .'.'.pathinfo($fileName, PATHINFO_EXTENSION);
        }

        $file->move($destinationPath, $fileName);

        Download::create([
            'name' => $request->download_name,
            'file' => $fileName,
        ]);

        return redirect()->route('downloads.show')
            ->with('success', 'Download form uploaded successfully');
    }

   public function show()
{
    $downloads = Download::latest()->paginate(10); // 10 per page
    return view('downloadsection.showdownload', compact('downloads'));
}

    public function view($id)
    {
        $download = Download::findOrFail($id);
        return view('downloadsection.viewdownload', compact('download'));
    }
    public function destroy($id)
{
    $download = Download::findOrFail($id);

    // file delete from folder
    $filePath = public_path('uploads/downloads/' . $download->file);
    if (file_exists($filePath)) {
        unlink($filePath);
    }

    // delete record
    $download->delete();

    return redirect()->route('downloads.show')
        ->with('success', 'Download deleted successfully');
}

}
