@extends('Dashboard.index')

@section('main-content')
<div class="container-fluid">
    <div class="card shadow">
        <div class="card-header my-sidebar-class text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">NFA Website Users</h4>
        </div>

        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Blocked At</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>

                        <td>
                            @if($user->is_blocked)
                            <span class="badge bg-danger">Blocked</span>
                            @else
                            <span class="badge bg-success">Active</span>
                            @endif
                        </td>

                        <td>{{ $user->blocked_at ? $user->blocked_at->format('d M Y, h:i A') : '-' }}</td>

                        <td>
                            <button class="btn btn-sm btn-primary mb-1" data-bs-toggle="modal"
                                data-bs-target="#profileModal{{ $user->id }}">
                                View Profile
                            </button>

                            @if($user->is_blocked)
                            <form action="{{ route('nfa-users.unblock', $user->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-sm btn-success">Unblock</button>
                            </form>
                            @else
                            <form action="{{ route('nfa-users.block', $user->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-sm btn-danger"
                                    onclick="return confirm('Are you sure?')">Block</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">
                            No NFA users found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>

                {{--
            </table> --}}
            </table>
            @foreach($users as $user)
            <div class="modal fade" id="profileModal{{ $user->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content border-0 shadow">

            <!-- Header -->
            <div class="modal-header my-sidebar-class text-white">
                <h5 class="modal-title">
                    <i class="bi bi-person-circle me-2"></i>
                    Profile Details
                </h5>
                <button type="button" class="btn-close btn-close-white"
                    data-bs-dismiss="modal"></button>
            </div>

            <!-- Body -->
            <div class="modal-body">

                @if($user->profile)

                <!-- Basic Info -->
                <div class="card mb-3 border-0 shadow-sm">
                    <div class="card-header my-logo-class fw-bold my-text-color">
                        Basic Information
                    </div>
                    <div class="card-body">
                        <p><strong>Name:</strong> {{ $user->name }}</p>
                        <p><strong>Email:</strong> {{ $user->email }}</p>
                        <p><strong>DOB:</strong> {{ $user->profile->date_of_birth ?? '-' }}</p>
                        <p><strong>Phone:</strong> {{ $user->profile->phone_number ?? '-' }}</p>
                        <p><strong>Address:</strong> {{ $user->profile->postal_address ?? '-' }}</p>
                        <p><strong>Bio:</strong> {{ $user->profile->bio ?? '-' }}</p>
                    </div>
                </div>

                <!-- Education -->
                <div class="card mb-3 border-0 shadow-sm">
                    <div class="card-header my-logo-class fw-bold my-text-color">
                        Education
                    </div>
                    <div class="card-body">
                        @forelse($user->profile->educations as $edu)
                            <div class="border rounded p-2 mb-2">
                                <strong class="my-text-color">{{ $edu->degree }}</strong><br>
                                <small>{{ $edu->institution_name }}</small>
                            </div>
                        @empty
                            <p class="text-muted mb-0">No education records</p>
                        @endforelse
                    </div>
                </div>

                <!-- Work History -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header my-logo-class fw-bold my-text-color">
                        Work History
                    </div>
                    <div class="card-body">
                        @forelse($user->profile->workHistories as $work)
                            <div class="border rounded p-2 mb-2">
                                <strong class="my-text-color">{{ $work->job_title }}</strong><br>
                                <small>{{ $work->company_name }}</small>
                            </div>
                        @empty
                            <p class="text-muted mb-0">No work history</p>
                        @endforelse
                    </div>
                </div>

                @else
                <!-- No Profile -->
                <div class="alert alert-warning text-center">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    No profile created
                </div>
                @endif

            </div>

            <!-- Footer -->
            <div class="modal-footer">
                <button class="btn my-btn-color text-white px-4"
                    data-bs-dismiss="modal">
                    Close
                </button>
            </div>

        </div>
    </div>
</div>

            @endforeach

            <!-- Pagination -->
            <div class="mt-3">
                {{ $users->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection