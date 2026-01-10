<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use Illuminate\Http\Request;

class CandidateApiController extends Controller
{
    //
      public function index(Request $request)
    {
        $query = Candidate::query();

        // General search
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

        // Filter by test_date
        if ($request->filled('test_date')) {
            $query->where('test_date', $request->test_date);
        }

        $candidates = $query->orderBy('sr_no')->paginate($request->get('per_page', 10));

        return response()->json($candidates);
    }
}
