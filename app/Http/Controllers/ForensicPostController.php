<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ForensicPost;
use Illuminate\Support\Facades\Storage;

class ForensicPostController extends Controller
{
    public function index()
    {
        $posts = ForensicPost::orderBy('tab')->get();
        return view('posts.forensicpost', compact('posts'));
    }

    public function store(Request $request)
    {
        $data = $request->only('tab','title','content');

        if ($request->hasFile('img1')) {
            $data['img1'] = $request->file('img1')->store('forensic_images','public');
        }
       

        ForensicPost::create($data);
        return redirect()->back()->with('success','Record added successfully!');
    }

    public function show($id)
    {
        $post = ForensicPost::findOrFail($id);
        return response()->json($post);
    }

    public function destroy($id)
    {
        $post = ForensicPost::findOrFail($id);

        if ($post->img1) Storage::disk('public')->delete($post->img1);

        $post->delete();
        return response()->json(['success'=>true]);
    }
}
