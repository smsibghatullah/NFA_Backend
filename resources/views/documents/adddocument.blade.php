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

    <div class="card shadow-lg border-0">
        <div class="card-header my-sidebar-class text-white">
            <h4 class="mb-0">Upload New Document</h4>
        </div>

        <div class="card-body">
            <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group mb-3">
                    <label class="my-text-color fw-bold">Document Name</label>
                    <input type="text" name="document_name" class="form-control" placeholder="Enter document name" required>
                </div>

                <div class="form-group mb-3">
                    <label class="my-text-color fw-bold">Upload PDF</label>
                    <input type="file" name="document_file" class="form-control" accept="application/pdf" required>
                    <small class="text-muted">Only PDF files allowed</small>
                </div>

                <button type="submit" class="btn my-btn-color text-white px-4">
                    <i class="fas fa-upload"></i> Upload Document
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
