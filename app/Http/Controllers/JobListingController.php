<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobListing;

class JobListingController extends Controller
{
    // Show all job listings
    public function index()
    {
        $jobs = JobListing::latest()->paginate(10); // paginate 10 per page
        return view('jobs.showjobs', compact('jobs'));
    }

    // Show form to add a new job
    public function create()
    {
        return view('jobs.addjob');
    }

    // Store new job
    public function store(Request $request)
    {
        $request->validate([
            'job_title' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'application_deadline' => 'required|date',
            'number_of_positions' => 'required|integer|min:1',
'salary_range' => 'nullable|numeric|min:0',
'required_education' => 'required|string|max:100',
'required_experience' => 'required|integer|min:0',
            'responsibilities' => 'nullable|string',
            'additional_info' => 'nullable|string',
        ]);

        JobListing::create($request->all());

        return redirect()->route('job-listings.index')->with('success', 'Job Listing added successfully!');
    }

    // Show edit form
    public function edit(JobListing $jobListing)
    {
        return view('jobs.addjob', compact('jobListing')); // reuse addjob.blade for edit
    }

    // Update job
    public function update(Request $request, JobListing $jobListing)
    {
        $request->validate([
    'job_title' => 'required|string|max:255',
    'location' => 'nullable|string|max:255',
    'application_deadline' => 'required|date',
    'number_of_positions' => 'required|integer|min:1',
    'salary_range' => 'nullable|numeric|min:0',
    'required_education' => 'required|string|max:100',
    'required_experience' => 'required|integer|min:0',
    'responsibilities' => 'nullable|string',
    'additional_info' => 'nullable|string',
]);


        $jobListing->update($request->all());

        return redirect()->route('job-listings.index')->with('success', 'Job Listing updated successfully!');
    }

    // Delete job
    public function destroy(JobListing $jobListing)
    {
        $jobListing->delete();
        return redirect()->route('job-listings.index')->with('success', 'Job Listing deleted successfully!');
    }
}
