@extends('Dashboard.index')

@section('main-content')
<div class="container-fluid">
    <div class="card shadow">
        <div class="card-header my-sidebar-class text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Job Applications</h4>
        </div>

        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>User Name</th>
                        <th>Job Title</th>
                        <th>CV</th>
                        <th>Degree</th>
                        <th>CNIC</th>
                        <th>Applied At</th>
                        <th>Action</th> <!-- New Action Column -->
                    </tr>
                </thead>
                <tbody>
                    @forelse($applications as $app)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $app->user->name ?? 'N/A' }}</td>
                        <td>{{ $app->job->title ?? 'N/A' }}</td>
                        <td>
                            @if($app->cv)
                            <a href="{{ Storage::url($app->cv) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                View CV
                            </a>
                            @else
                            -
                            @endif
                        </td>
                        <td>
                            @if($app->degree)
                            <a href="{{ Storage::url($app->degree) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                View Degree
                            </a>
                            @else
                            -
                            @endif
                        </td>
                        <td>
                            @if($app->cnic)
                            <a href="{{ Storage::url($app->cnic) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                View CNIC
                            </a>
                            @else
                            -
                            @endif
                        </td>
                        <td>{{ $app->created_at->format('d M Y, h:i A') }}</td>
                        <td>
                            <!-- Action Button -->
                            @if($app->user->email)
                            <a href="mailto:{{ $app->user->email }}" class="btn btn-sm btn-success">
                                Send Email
                            </a>
                            @else
                            -
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted">
                            No job applications found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="mt-3">
                {{ $applications->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection
