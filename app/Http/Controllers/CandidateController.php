<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidate;
use App\Imports\CandidatesImport;
use Maatwebsite\Excel\Facades\Excel;

class CandidateController extends Controller
{
    public function index()
    {
        return view('candidates.addcandidates');
    }

    // Excel Import
    public function store(Request $request)
    {
        if ($request->hasFile('excel_file')) {

            $request->validate([
                'excel_file' => 'required|mimes:xlsx,xls'
            ]);

            Excel::import(new CandidatesImport, $request->file('excel_file'));

            return redirect()->route('candidates.show')
                ->with('success', 'Candidates imported successfully');
        }

        return back()->with('error', 'Please upload excel file');
    }

    // Manual Store
    public function manualStore(Request $request)
    {
        $request->validate([
        'sr_no' => 'required|numeric',
        'roll_no' => 'required',
        'name' => 'required',
        'mobile_no' => 'nullable',
        'paper' => 'required',
        'test_date' => 'required|date',
        'session' => 'required',
        'reporting_time' => 'required',
        'conduct_time' => 'required',
        'venue' => 'required',
    ]);

        Candidate::create($request->all());

        return redirect()->route('candidates.show')
            ->with('success', 'Candidate added successfully');
    }

    public function show(Request $request)
{
    $query = Candidate::query();

    // General search across multiple columns
    if ($request->filled('query')) {
        $search = $request->query('query');
        $query->where(function($q) use ($search) {
            $q->where('name', 'like', "%$search%")
              ->orWhere('roll_no', 'like', "%$search%")
              ->orWhere('cnic', 'like', "%$search%")
              ->orWhere('mobile_no', 'like', "%$search%")
              ->orWhere('sr_no', 'like', "%$search%")
              ->orWhere('venue', 'like', "%$search%")
              ->orWhere('paper', 'like', "%$search%");
        });
    }

    // Filter by Test Date if provided
    if ($request->filled('test_date')) {
        $query->where('test_date', $request->test_date);
    }

    $candidates = $query->orderBy('sr_no')->paginate(10);

    return view('candidates.showcandidates', compact('candidates'));
}

public function edit($id)
{
    $candidate = Candidate::findOrFail($id);
    return view('candidates.addcandidates', compact('candidate')); // <-- same Blade as add
}


public function update(Request $request, $id)
{
    $request->validate([
        'sr_no' => 'required|numeric',
        'roll_no' => 'required',
        'name' => 'required',
        'mobile_no' => 'nullable',
        'paper' => 'required',
        'test_date' => 'required|date',
        'session' => 'required',
        'reporting_time' => 'required',
        'conduct_time' => 'required',
        'venue' => 'required',
    ]);

    $candidate = Candidate::findOrFail($id);
    $candidate->update($request->all());

    return redirect()->route('candidates.show')
        ->with('success', 'Candidate updated successfully');
}

}
