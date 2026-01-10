@extends('Dashboard.index')

@section('main-content')
<div class="container-fluid">
    <div class="card shadow">
        <div class="card-header my-sidebar-class text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Job Listings</h4>
            <a href="{{ route('job-listings.create') }}" class="btn my-btn-color text-white">
                + Add Job
            </a>
        </div>

        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Job Title</th>
                        <th>Location</th>
                        <th>Deadline</th>
                        <th>Positions</th>
                        <th>Education</th>
                        <th>Experience in month(s)</th>
                        {{-- <th>Status</th> --}}
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jobs as $job)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $job->job_title }}</td>
                        <td>{{ $job->location }}</td>
                        <td>{{ $job->application_deadline }}</td>
                        <td>{{ $job->number_of_positions }}</td>
                        <td>{{ $job->required_education }}</td>
                        <td>{{ $job->required_experience }}</td>
                        {{-- <td>{{ ucfirst($job->status) }}</td> --}}
                        <td>
                            <a href="{{ route('job-listings.edit', $job->id) }}" class="btn btn-sm btn-primary mb-1">Edit</a>
                            <form action="{{ route('job-listings.destroy', $job->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    @if($jobs->isEmpty())
                    <tr>
                        <td colspan="9" class="text-center text-muted">No job listings found.</td>
                    </tr>
                    @endif
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="mt-3">
                {{ $jobs->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
