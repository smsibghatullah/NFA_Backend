<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OurService;
use Illuminate\Support\Facades\Storage;

class OurServicesController extends Controller
{
    // Show all services
    public function index()
    {
        $services = OurService::latest()->get();
        return view('posts.our-services', compact('services'));
    }

    // Store service (for admin)
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['title', 'content']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('services', 'public');
        }

        OurService::create($data);

        return redirect()->back()->with('success', 'Service added successfully!');
    }

    // Edit & Update functions can be added similarly
}
