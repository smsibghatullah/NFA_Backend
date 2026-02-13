@extends('Dashboard.index')

@section('main-content')
<div class="container-fluid">
{{-- SUCCESS MESSAGE --}}
@if(session('success'))
    <div id="success-alert" class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
    </div>
@endif

{{-- ERROR MESSAGE --}}
@if($errors->any())
    <div id="error-alert" class="alert alert-danger alert-dismissible fade show">
        <ul class="mb-0 mt-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    {{-- Excel Upload --}}
    <div class="card shadow mb-4">
        <div class="card-header my-sidebar-class text-white">
            <h4>Upload Candidates (Excel)</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('candidates.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group mb-3">
                    <label class="my-text-color fw-bold">Upload Excel File</label>
                    <input type="file" name="excel_file" class="form-control">
                    <small class="text-muted">Only .xlsx / .xls allowed</small>
                </div>

                <button type="submit" class="btn my-btn-color text-white">
                    <i class="fas fa-file-excel"></i> Import Candidates
                </button>
            </form>
        </div>
    </div>

    {{-- Manual Entry --}}
    <div class="card shadow mb-4">
        <div class="card-header my-sidebar-class text-white">
            <h4>{{ isset($candidate) ? 'Edit Candidate' : ' Add Candidate Manually' }}</h4>
        </div>

        <div class="card-body">
            <form action="{{ isset($candidate) ? route('candidates.update', $candidate->id) : route('candidates.manual.store') }}" method="POST">
                @csrf
                @if(isset($candidate))
                    @method('PUT')
                @endif

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="my-text-color fw-bold">SR No</label>
                        <input type="number" name="sr_no" class="form-control" value="{{ $candidate->sr_no ?? '' }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="my-text-color fw-bold">Roll No</label>
                        <input type="text" name="roll_no" class="form-control" value="{{ $candidate->roll_no ?? '' }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="my-text-color fw-bold">Name</label>
                        <input type="text" name="name" class="form-control" value="{{ $candidate->name ?? '' }}" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="my-text-color fw-bold">Father Name</label>
                        <input type="text" name="father_name" class="form-control" value="{{ $candidate->father_name ?? '' }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="my-text-color fw-bold">CNIC</label>
                        <input type="text" name="cnic" class="form-control" value="{{ $candidate->cnic ?? '' }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="my-text-color fw-bold">Post Applied For</label>
                        <input type="text" name="post_applied_for" class="form-control" value="{{ $candidate->post_applied_for ?? '' }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="my-text-color fw-bold">Mobile No</label>
                        <input type="text" name="mobile_no" class="form-control" value="{{ $candidate->mobile_no ?? '' }}">
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="my-text-color fw-bold">Postal Address</label>
                        <textarea name="postal_address" class="form-control" rows="2">{{ $candidate->postal_address ?? '' }}</textarea>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="my-text-color fw-bold">Paper</label>
                        <input type="text" name="paper" class="form-control" value="{{ $candidate->paper ?? '' }}" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="my-text-color fw-bold">Test Date</label>
                        <input type="date" name="test_date" class="form-control" value="{{ $candidate->test_date ?? '' }}" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="my-text-color fw-bold">Session</label>
                        <input type="text" name="session" class="form-control" value="{{ $candidate->session ?? '' }}" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="my-text-color fw-bold">Reporting Time</label>
                        <input type="time" name="reporting_time" class="form-control" value="{{ $candidate->reporting_time ?? '' }}" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="my-text-color fw-bold">Conduct Time</label>
                        <input type="text" name="conduct_time" class="form-control" value="{{ $candidate->conduct_time ?? '' }}" required>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="my-text-color fw-bold">Venue</label>
                        <textarea name="venue" class="form-control" rows="2" required>{{ $candidate->venue ?? '' }}</textarea>
                    </div>
                </div>

                <button type="submit" class="btn my-btn-color text-white">
                    <i class="fas fa-save"></i> {{ isset($candidate) ? 'Update Candidate' : 'Save Candidate' }}
                </button>
            </form>
        </div>
    </div>

</div>
@endsection
