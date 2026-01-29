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
                        <button
 class="btn btn-sm btn-warning edit-btn"
 data-id="{{ $c->id }}"
 data-name="{{ $c->name }}"
 data-mobile="{{ $c->mobile_no }}"
 data-paper="{{ $c->paper }}"
 data-date="{{ $c->test_date }}"
 data-session="{{ $c->session }}"
 data-reporting="{{ $c->reporting_time }}"
 data-conduct="{{ $c->conduct_time }}"
 data-venue="{{ $c->venue }}"
 data-sr="{{ $c->sr_no }}"
 data-roll="{{ $c->roll_no }}"
 data-bs-toggle="modal"
 data-bs-target="#editCandidateModal"
>
<i class="fas fa-edit"></i> Edit
</button>


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
<!-- Edit Candidate Modal -->
<div class="modal fade" id="editCandidateModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form method="POST" id="editForm">
        @csrf
        @method('PUT')

        <div class="modal-content">
            <div class="modal-header my-sidebar-class text-white">
                <h5 class="modal-title">Edit Candidate</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

          <div class="modal-body row g-3">

    <input type="hidden" id="edit_sr_no" name="sr_no">
    <input type="hidden" id="edit_roll_no" name="roll_no">

    <div class="col-md-6">
        <label>Name</label>
        <input type="text" name="name" id="edit_name" class="form-control">
    </div>

    <div class="col-md-6">
        <label>Mobile</label>
        <input type="text" name="mobile_no" id="edit_mobile" class="form-control">
    </div>

    <div class="col-md-6">
        <label>Paper</label>
        <input type="text" name="paper" id="edit_paper" class="form-control">
    </div>

    <div class="col-md-6">
        <label>Test Date</label>
        <input type="date" name="test_date" id="edit_date" class="form-control">
    </div>

    <div class="col-md-6">
        <label>Session</label>
        <input type="text" name="session" id="edit_session" class="form-control">
    </div>

    <div class="col-md-6">
        <label>Reporting Time</label>
        <input type="time" name="reporting_time" id="edit_reporting" class="form-control">
    </div>

    <div class="col-md-6">
        <label>Conduct Time</label>
        <input type="time" name="conduct_time" id="edit_conduct" class="form-control">
    </div>

    <div class="col-md-6">
        <label>Venue</label>
        <input type="text" name="venue" id="edit_venue" class="form-control">
    </div>

</div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Update
                </button>
            </div>
        </div>
    </form>
  </div>
</div>
<script>
document.querySelectorAll('.edit-btn').forEach(btn => {
    btn.addEventListener('click', function () {

        document.getElementById('edit_name').value = this.dataset.name;
        document.getElementById('edit_mobile').value = this.dataset.mobile;
        document.getElementById('edit_paper').value = this.dataset.paper;
        document.getElementById('edit_date').value = this.dataset.date;
        document.getElementById('edit_session').value = this.dataset.session;
        document.getElementById('edit_reporting').value = this.dataset.reporting;
        document.getElementById('edit_conduct').value = this.dataset.conduct;
        document.getElementById('edit_venue').value = this.dataset.venue;

        document.getElementById('edit_sr_no').value = this.dataset.sr;
        document.getElementById('edit_roll_no').value = this.dataset.roll;

        document.getElementById('editForm').action =
            `/candidates/${this.dataset.id}`;
    });
});
</script>

@endsection
