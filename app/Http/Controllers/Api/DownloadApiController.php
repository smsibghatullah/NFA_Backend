<?php

    namespace App\Http\Controllers\Api;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use App\Models\Download;

    class DownloadApiController extends Controller
    {
        // public function __construct()
        // {
        //     // HARD SECURITY (route + controller both)
        //     $this->middleware('auth:sanctum');
        // }

        // GET: all downloads
        public function index()
        {
            return response()->json([
                'status' => true,
                'downloads' => Download::latest()->get()
            ]);
        }

        // POST: upload download PDF
        public function store(Request $request)
        {
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

        // GET: single download
        public function show($id)
        {
            $download = Download::findOrFail($id);

            return response()->json([
                'status' => true,
                'data' => $download,
                'file_url' => asset('uploads/downloads/'.$download->file)
            ]);
        }
    }
