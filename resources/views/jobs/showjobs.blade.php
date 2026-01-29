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
<button
 class="btn btn-sm btn-warning edit-job-btn"
 data-id="{{ $job->id }}"
 data-title="{{ $job->job_title }}"
 data-location="{{ $job->location }}"
 data-deadline="{{ $job->application_deadline }}"
 data-positions="{{ $job->number_of_positions }}"
 data-salary="{{ $job->salary_range }}"
 data-education="{{ $job->required_education }}"
 data-experience="{{ $job->required_experience }}"
 data-responsibilities="{{ $job->responsibilities }}"
 data-info="{{ $job->additional_info }}"
 data-bs-toggle="modal"
 data-bs-target="#editJobModal"
>
 <i class="fas fa-edit"></i> Edit
</button>
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
<!-- Edit Job Modal -->
<div class="modal fade" id="editJobModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form method="POST" id="editJobForm">
        @csrf
        @method('PUT')

        <div class="modal-content">
            <div class="modal-header my-sidebar-class text-white">
                <h5 class="modal-title">Edit Job Listing</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <div class="mb-3">
                    <label>Job Title</label>
                    <input type="text" name="job_title" id="edit_job_title" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Location</label>
                    <input type="text" name="location" id="edit_location" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Application Deadline</label>
                    <input type="date" name="application_deadline" id="edit_deadline" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Number of Positions</label>
                    <input type="number" name="number_of_positions" id="edit_positions" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Salary Range</label>
                    <input type="number" name="salary_range" id="edit_salary" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Required Education</label>
                    <select name="required_education" id="edit_education" class="form-control">
                        <option value="">-- Select --</option>
                        <option value="Matric">Matric</option>
                        <option value="Intermediate">Intermediate</option>
                        <option value="Bachelors">Bachelors</option>
                        <option value="Master">Master</option>
                        <option value="PhD">PhD</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Required Experience (months)</label>
                    <input type="number" name="required_experience" id="edit_experience" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Responsibilities</label>
                    <textarea name="responsibilities" id="edit_responsibilities" class="form-control"></textarea>
                </div>

                <div class="mb-3">
                    <label>Additional Info</label>
                    <textarea name="additional_info" id="edit_info" class="form-control"></textarea>
                </div>

            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Update Job
                </button>
            </div>
        </div>
    </form>
  </div>
</div>
<script>
document.querySelectorAll('.edit-job-btn').forEach(btn => {
    btn.addEventListener('click', function () {

        document.getElementById('edit_job_title').value = this.dataset.title;
        document.getElementById('edit_location').value = this.dataset.location;
        document.getElementById('edit_deadline').value = this.dataset.deadline;
        document.getElementById('edit_positions').value = this.dataset.positions;
        document.getElementById('edit_salary').value = this.dataset.salary;
        document.getElementById('edit_education').value = this.dataset.education;
        document.getElementById('edit_experience').value = this.dataset.experience;
        document.getElementById('edit_responsibilities').value = this.dataset.responsibilities;
        document.getElementById('edit_info').value = this.dataset.info;

        document.getElementById('editJobForm').action =
            `/job-listings/${this.dataset.id}`;
    });
});
</script>

@endsection
