<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ForensicPost;

class ForensicApiController extends Controller
{
    // ✅ Public view API (all forensic posts)
    public function index(Request $request)
    {
        $this->validateApiKey($request);

        $posts = ForensicPost::latest()->get()->map(function ($post) {
            return [
                'id' => $post->id,
                'tab' => $post->tab,
                'title' => $post->title,
                'content' => $post->content,
                'image' => $post->img1 ? asset('storage/' . $post->img1) : null,
                'created_at' => $post->created_at,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $posts
        ], 200);
    }

    // ✅ Single forensic post
    public function show(Request $request, $id)
    {
        $this->validateApiKey($request);

        $post = ForensicPost::find($id);

        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Forensic post not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $post->id,
                'tab' => $post->tab,
                'title' => $post->title,
                'content' => $post->content,
                'image' => $post->img1 ? asset('storage/' . $post->img1) : null,
                'created_at' => $post->created_at,
            ]
        ], 200);
    }

    // ✅ Latest forensic post
    public function latest(Request $request)
    {
        $this->validateApiKey($request);

        $post = ForensicPost::latest()->first();

        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'No forensic post found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $post->id,
                'tab' => $post->tab,
                'title' => $post->title,
                'content' => $post->content,
                'image' => $post->img1 ? asset('storage/' . $post->img1) : null,
                'created_at' => $post->created_at,
            ]
        ], 200);
    }

    // ✅ API key validation helper
    private function validateApiKey(Request $request)
{
    // Get key from query param or Authorization header
    $key = $request->query('api_key') 
           ?? str_replace('Bearer ', '', $request->header('Authorization'));

    if (!$key || $key !== env('GENERAL_API_KEY')) {
        abort(response()->json([
            'status' => false,
            'message' => 'Unauthorized: Invalid API key'
        ], 401));
    }
}
}
