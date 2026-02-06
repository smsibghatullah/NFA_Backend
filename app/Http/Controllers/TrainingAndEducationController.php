<?php
namespace App\Http\Controllers;

use App\Models\TrainingAndEducation;
use Illuminate\Http\Request;

class TrainingAndEducationController extends Controller
{
    public function index()
    {
        $posts = TrainingAndEducation::latest()->get();
        return view('posts.trainingandeducation', compact('posts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        $data = $request->only('title', 'content');

        if ($request->hasFile('img1')) {
            $data['img1'] = $request->file('img1')->store('training', 'public');
        }

        if ($request->hasFile('img2')) {
            $data['img2'] = $request->file('img2')->store('training', 'public');
        }

        TrainingAndEducation::create($data);

        return back()->with('success', 'Record Saved');
    }

    public function show($id)
    {
        $post = TrainingAndEducation::find($id);
        if (!$post) return response()->json(['error' => 'Record not found'], 404);

        return response()->json([
            'id' => $post->id,
            'title' => $post->title,
            'content' => $post->content,
            'img1' => $post->img1 ? $post->img1 : null,
            'img2' => $post->img2 ? $post->img2 : null
        ]);
    }

    public function destroy($id)
    {
        TrainingAndEducation::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }
}
