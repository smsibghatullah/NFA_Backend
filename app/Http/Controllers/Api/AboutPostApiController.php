<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AboutPost;
use Illuminate\Support\Facades\Storage;

class AboutPostApiController extends Controller
{
    // ✅ Public view API (JSON only)
    public function index()
    {
        $posts = AboutPost::select('id', 'title', 'content', 'created_at')
            ->where('id', 1) // only active
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $posts
        ], 200);
    }

    // ✅ Single post view (optional but useful)
    public function show($id)
    {
        $post = AboutPost::select('id', 'title', 'content', 'created_at')
            ->where('id', 1)
            ->find($id);

        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Record not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $post
        ], 200);
    }

public function latest()
{
    $post = AboutPost::orderBy('id', 'desc')->first(); // remove where('id',1)

    if (!$post) {
        return response()->json([
            'success' => false,
            'message' => 'No record found'
        ], 404);
    }

    return response()->json([
        'success' => true,
        'data' => [
            'id' => $post->id,
            'title' => $post->title,
            'content' => $post->content,
            'img1' => $post->img1 ? asset('storage/' . $post->img1) : null,
            'img2' => $post->img2 ? asset('storage/' . $post->img2) : null,
            'created_at' => $post->created_at
        ]
    ], 200);
}


}
