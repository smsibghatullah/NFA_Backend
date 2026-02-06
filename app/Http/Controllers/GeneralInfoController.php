<?php

namespace App\Http\Controllers;

use App\Models\GeneralInfo;
use Illuminate\Http\Request;

class GeneralInfoController extends Controller
{
    public function index()
    {
        $info = GeneralInfo::latest()->first();
        return view('generalinfo.index', compact('info'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
        ]);

        GeneralInfo::create([
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'facebook' => $request->facebook,
            'twitter' => $request->twitter,
            'instagram' => $request->instagram,
            'is_visible' => $request->is_visible ?? 0,
        ]);

        return redirect()->back()->with('success', 'General info added successfully');
    }

    public function edit($id)
    {
        $info = GeneralInfo::findOrFail($id);
        return view('generalinfo.edit', compact('info'));
    }

    public function update(Request $request, $id)
    {
        $info = GeneralInfo::findOrFail($id);

        $info->update($request->all());

        return redirect()->route('generalinfo.index')
            ->with('success', 'Updated successfully');
    }

    public function destroy($id)
    {
        GeneralInfo::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Deleted successfully');
    }
}
