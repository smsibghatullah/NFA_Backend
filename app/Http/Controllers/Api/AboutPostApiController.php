<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AboutPost;
use Illuminate\Support\Facades\Storage;

class AboutPostApiController extends Controller
{
    // ✅ List all posts (API key protected)
    public function index(Request $request)
    {
        $this->validateApiKey($request);

        $posts = AboutPost::select('id', 'title', 'content', 'created_at')
            ->where('id', 1) // only active
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $posts
        ], 200);
    }

    // ✅ Single post view (API key protected)
    public function show(Request $request, $id)
    {
        $this->validateApiKey($request);

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

    // ✅ Latest post (API key protected)
    public function latest(Request $request)
    {
        $this->validateApiKey($request);
        // dd('here', $request->all());
        $post = AboutPost::orderBy('id', 'desc')->first();

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
