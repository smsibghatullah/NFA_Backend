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

{{-- JS for auto dismiss --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Success alert
        let successAlert = document.getElementById('success-alert');
        if(successAlert) {
            setTimeout(() => {
                successAlert.classList.remove('show');
                successAlert.classList.add('hide');
                successAlert.style.display = 'none';
            }, 3000); // 3000ms = 3 seconds
        }

        // Error alert
        let errorAlert = document.getElementById('error-alert');
        if(errorAlert) {
            setTimeout(() => {
                errorAlert.classList.remove('show');
                errorAlert.classList.add('hide');
                errorAlert.style.display = 'none';
            }, 3000);
        }
    });
</script>



    <div class="card shadow border-0">
        <div class="card-header my-sidebar-class text-white">
            <h4 class="mb-0">Add Tender</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('tenders.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="fw-bold">Tender Title</label>
                    <input type="text"
                           name="title"
                           class="form-control @error('title') is-invalid @enderror"
                           value="{{ old('title') }}"
                           required>

                    @error('title')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="fw-bold">Upload PDF</label>
                    <input type="file"
                           name="file"
                           class="form-control @error('file') is-invalid @enderror"
                           accept="application/pdf"
                           required>

                    @error('file')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                    <small class="text-muted">Only PDF file allowed</small>
                </div>

                <input type="hidden" name="status" value="new">

                <button type="submit" class="btn my-btn-color text-white">
                    Upload
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
