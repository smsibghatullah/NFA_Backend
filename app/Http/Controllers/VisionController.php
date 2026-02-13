<?php

namespace App\Http\Controllers;

use App\Models\Vision;
use Illuminate\Http\Request;

class VisionController extends Controller
{
    public function index()
    {
        $visions = Vision::latest()->get();
        return view('pages.vision.index', compact('visions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required',
        ]);
        $data = $request->only(keys: 'content');
        // dd($data);

        Vision::create(
            $data
        );

        return redirect()->back()->with('success', 'Vision content added successfully.');
    }

    public function show($id)
    {
        return Vision::findOrFail($id);
    }

    public function edit($id)
    {
        $vision = Vision::findOrFail($id);
        return view('pages.vision.edit', compact('vision'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'content' => 'required',
        ]);

        $vision = Vision::findOrFail($id);
        $data = $request->only(keys: 'content');

        $vision->update($data);
        return redirect()->route('vision.index')
            ->with('success', 'Vision content updated successfully.');
    }

    public function destroy($id)
    {
        Vision::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }
}
