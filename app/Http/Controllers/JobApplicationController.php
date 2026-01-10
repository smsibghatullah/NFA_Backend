<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobApplication;

class JobApplicationController extends Controller
{
    public function showApplications()
    {
    $applications = JobApplication::with(['user','job'])->latest()->paginate(10); // 10 per page
        return view('jobapplication.showapplication', compact('applications'));
    }
}
