@extends('Dashboard.index')

@section('main-content')
<div class="container-fluid">

    {{-- Search / Filter --}}
    <div class="card shadow mb-4">
        <div class="card-header my-sidebar-class text-white">
            <h4>Search Candidates</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('candidates.show') }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <input type="text" name="query" class="form-control" placeholder="Search by Name, Roll, CNIC, Mobile, SR No, Venue, Paper" value="{{ request('query') }}">
                </div>
                <div class="col-md-2">
                    <input type="date" name="test_date" class="form-control" placeholder="Test Date" value="{{ request('test_date') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn my-btn-color text-white">
                        <i class="fas fa-search"></i> Search
                    </button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('candidates.show') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Clear
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Candidates Table --}}
    <div class="card shadow">
        <div class="card-header my-sidebar-class text-white">
            <h4>Candidates List</h4>
        </div>

        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Sr#</th>
                        <th>Roll No</th>
                        <th>Name</th>
                        <th>Father</th>
                        <th>CNIC</th>
                        <th>Post</th>
                        <th>Mobile</th>
                        <th>Test Date</th>
                        <th>Venue</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($candidates as $c)
                    <tr>
                        <td>{{ $c->sr_no }}</td>
                        <td>{{ $c->roll_no }}</td>
                        <td>{{ $c->name }}</td>
                        <td>{{ $c->father_name }}</td>
                        <td>{{ $c->cnic }}</td>
                        <td>{{ $c->post_applied_for }}</td>
                        <td>{{ $c->mobile_no }}</td>
                        <td>{{ $c->test_date }}</td>
                        <td>{{ $c->venue }}</td>
                        <td>
                            <a href="{{ route('candidates.edit', $c->id) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center">No candidates found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Pagination --}}
            <div class="mt-3">
                {{ $candidates->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

</div>
@endsection
