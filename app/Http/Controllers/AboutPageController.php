<?php

namespace App\Http\Controllers;

use App\Models\AboutPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutPageController extends Controller
{
    public function index()
    {
        $posts = AboutPage::latest()->get();
        return view('pages.about.index', compact('posts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required',
            'content' => 'required',
            'image'   => 'nullable|image',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('about', 'public');
        }
    $data = $request->only('title','content');

        // AboutPage::create([
        //     'title'   => $request->title,
        //     'image'   => $imagePath,
        //     'content' => $request->content,
        // ]);
        $data['image'] = $imagePath;
        AboutPage::create($data);
        return back()->with('success', 'About content added successfully');
    }

    public function show($id)
    {
        return AboutPage::findOrFail($id);
    }

    public function destroy($id)
    {
        $post = AboutPage::findOrFail($id);

        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();
        return response()->json(['success' => true]);
    }
}
