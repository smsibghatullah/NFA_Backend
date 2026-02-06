<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TrainingAndEducation;
use Illuminate\Http\Request;

class TrainingAndEducationApiController extends Controller
{
    public function index()
    {
        $posts = TrainingAndEducation::latest()->get();

        return response()->json([
            'success' => true,
            'data' => $posts
        ], 200);
    }

    public function show($id)
    {
        $post = TrainingAndEducation::find($id);

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
        $post = TrainingAndEducation::orderBy('id', 'desc')->first();

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
