@extends('Dashboard.index')

@section('main-content')
<div class="container-fluid">
    <div class="card shadow border-0">
        <div class="card-header my-sidebar-class text-white">
            <h4 class="mb-0">Add Job Listing</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('job-listings.store') }}" method="POST">
                @csrf

                <div class="form-group mb-3">
                    <label class="my-text-color fw-bold">Job Title</label>
                    <input type="text" name="job_title" class="form-control" placeholder="Enter job title" required>
                </div>

                <div class="form-group mb-3">
                    <label class="my-text-color fw-bold">Location</label>
                    <input type="text" name="location" class="form-control" placeholder="Enter location">
                </div>

                <div class="form-group mb-3">
                    <label class="my-text-color fw-bold">Application Deadline</label>
                    <input type="date" name="application_deadline" class="form-control" required>
                </div>

                <div class="form-group mb-3">
                    <label class="my-text-color fw-bold">Number of Positions</label>
                    <input type="number" name="number_of_positions" class="form-control" value="1" min="1">
                </div>

                <div class="form-group mb-3">
                    <label class="my-text-color fw-bold">Salary Range</label>
                    <input type="text" name="salary_range" class="form-control" placeholder="e.g., 50000-70000 PKR">
                </div>


                <div class="form-group mb-3">
                    <label class="my-text-color fw-bold">Required Education</label>
                    <select name="required_education" class="form-control">
                        <option value="Matric">Matric</option>
                        <option value="Intermediate">Intermediate</option>
                        <option value="Bachelors">Bachelors</option>
                        <option value="Master">Master</option>
                    </select>
                </div>

                <div class="form-group mb-4">
                    <label class="my-text-color fw-bold">Required Experience (in months or false)</label>
                    <input type="text" name="required_experience" class="form-control" value="false"
                        placeholder="e.g., 12 or false">
                </div>
                <div class="form-group mb-3">
                    <label class="my-text-color fw-bold">Responsibilities</label>
                    <textarea name="responsibilities" class="form-control"
                        placeholder="Enter job responsibilities"></textarea>
                </div>

                <div class="form-group mb-3">
                    <label class="my-text-color fw-bold">Additional Info</label>
                    <textarea name="additional_info" class="form-control"
                        placeholder="Any extra info or instructions"></textarea>
                </div>



                <button type="submit" class="btn my-btn-color text-white px-4">
                    <i class="fas fa-plus-circle"></i> Add Job
                </button>
            </form>
        </div>
    </div>
</div>
@endsection