<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AboutPage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class AboutApiPageController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | ✅ All records
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
{
    $this->validateApiKey($request); // ✅ check API key

    $posts = AboutPage::latest()->get()->map(function ($post) {
        return $this->formatPost($post);
    });

    return response()->json([
        'success' => true,
        'data' => $posts
    ], 200);
}

public function show(Request $request, $id)
{
    $this->validateApiKey($request); // ✅ check API key

    $post = AboutPage::find($id);

    if (!$post) {
        return response()->json([
            'success' => false,
            'message' => 'Record not found'
        ], 404);
    }

    return response()->json([
        'success' => true,
        'data' => $this->formatPost($post)
    ], 200);
}

public function latest(Request $request)
{
    $this->validateApiKey($request); // ✅ check API key

    $post = AboutPage::latest()->first();

    if (!$post) {
        return response()->json([
            'success' => false,
            'message' => 'No record found'
        ], 404);
    }

    return response()->json([
        'success' => true,
        'data' => $this->formatPost($post)
    ], 200);
}


    /*
    |--------------------------------------------------------------------------
    | ✅ Helper (image URL format)
    |--------------------------------------------------------------------------
    */
    private function formatPost($post)
    {
        return [
            'id' => $post->id,
            'title' => $post->title,
            'content' => $post->content,
            'image' => $post->image
                ? asset('storage/' . $post->image)
                : null,
            'created_at' => $post->created_at
        ];
    }
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
