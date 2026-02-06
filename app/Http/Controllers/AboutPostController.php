<?php

namespace App\Http\Controllers;
use App\Models\AboutPost;
use Illuminate\Http\Request;

class AboutPostController extends Controller
{
    public function index()
    {
        $posts = AboutPost::latest()->get();
        return view('posts.aboutpost', compact('posts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required'
        ]);

        $data = $request->only('title','content');

        if ($request->hasFile('img1')) {
            $data['img1'] = $request->file('img1')->store('about','public');
        }

        if ($request->hasFile('img2')) {
            $data['img2'] = $request->file('img2')->store('about','public');
        }

        AboutPost::create($data);

        return back()->with('success','Record Saved');
    }

    public function show($id)
    {
        return AboutPost::findOrFail($id);
    }

    public function destroy($id)
    {
        AboutPost::findOrFail($id)->delete();
        return response()->json(['success'=>true]);
    }
}
