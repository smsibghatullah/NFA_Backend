<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tender;
use Illuminate\Support\Str;

class TenderController extends Controller
{
    public function index()
    {
        return view('pages.tendorandpublication.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'file'  => 'required|mimes:pdf,doc,docx',
        ]);

        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();

        $destinationPath = public_path('uploads/tenders');

        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        if (file_exists($destinationPath.'/'.$fileName)) {
            $fileName = pathinfo($fileName, PATHINFO_FILENAME)
                        .'_'.Str::random(5)
                        .'.'.pathinfo($fileName, PATHINFO_EXTENSION);
        }

        $file->move($destinationPath, $fileName);

        Tender::create([
            'title'  => $request->title,
            'file'   => $fileName,
            'status' => 'new', // default hidden
        ]);

        return redirect()->route('tenders.show')
            ->with('success', 'Tender uploaded successfully');
    }

    public function show()
    {
        $tenders = Tender::latest()->paginate(10);
        return view('pages.tendorandpublication.show', compact('tenders'));
    }

    public function view($id)
    {
        $tender = Tender::findOrFail($id);
        return view('pages.tendorandpublication.view', compact('tender'));
    }

    public function destroy($id)
    {
        $tender = Tender::findOrFail($id);

        $filePath = public_path('uploads/tenders/' . $tender->file);
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        $tender->delete();

        return redirect()->route('tenders.show')
            ->with('success', 'Tender deleted successfully');
    }

    // STATUS UPDATE
    public function updateStatus(Request $request, $id)
    {
        $tender = Tender::findOrFail($id);
        $tender->status = $request->status;
        $tender->save();

        return back()->with('success', 'Tender status updated');
    }
}
