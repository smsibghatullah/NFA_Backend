@extends('Dashboard.index')

@section('main-content')
   <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Dashboard</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <h1>Welcome to the Dashboard</h1>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
<div class="container-fluid">

    {{-- FORM CARD --}}
    <div class="card shadow border-0">
        <div class="card-header my-sidebar-class text-white">
            <h4 class="mb-0">General Information</h4>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('generalinfo.store') }}">
                @csrf

                <div class="form-group mb-3">
                    <label class="my-text-color fw-bold">Email</label>
                    <input type="email" name="email" class="form-control"
                        placeholder="Enter official email" required>
                </div>

                <div class="form-group mb-3">
                    <label class="my-text-color fw-bold">Phone Number</label>
                    <input type="text" name="phone" class="form-control"
                        placeholder="Enter contact number" required>
                </div>

                <div class="form-group mb-3">
                    <label class="my-text-color fw-bold">Address</label>
                    <textarea name="address" class="form-control"
                        placeholder="Enter complete address" required></textarea>
                </div>

                <div class="form-group mb-3">
                    <label class="my-text-color fw-bold">Facebook Link (Optional)</label>
                    <input type="url" name="facebook" class="form-control"
                        placeholder="https://facebook.com/yourpage">
                </div>

                <div class="form-group mb-3">
                    <label class="my-text-color fw-bold">Twitter / X Link (Optional)</label>
                    <input type="url" name="twitter" class="form-control"
                        placeholder="https://twitter.com/yourprofile">
                </div>

                <div class="form-group mb-3">
                    <label class="my-text-color fw-bold">Instagram Link (Optional)</label>
                    <input type="url" name="instagram" class="form-control"
                        placeholder="https://instagram.com/yourprofile">
                </div>

                <div class="form-group mb-4">
                    <label class="my-text-color fw-bold">
                        <input type="checkbox" name="is_visible" value="1" checked>
                        Visible on Website
                    </label>
                </div>

                <button type="submit" class="btn my-btn-color text-white px-4">
                    <i class="fas fa-save"></i> Save Information
                </button>
            </form>
        </div>
    </div>

    {{-- SHOW EXISTING RECORD --}}
    @if($info)
    <div class="card shadow border-0 mt-4">
        <div class="card-header my-sidebar-class text-white">
            <h5 class="mb-0">Current Information</h5>
        </div>

        <div class="card-body">
            <p><strong>Email:</strong> {{ $info->email }}</p>
            <p><strong>Phone:</strong> {{ $info->phone }}</p>
            <p><strong>Address:</strong> {{ $info->address }}</p>

            <p>
                <strong>Status:</strong>
                @if($info->is_visible)
                    <span class="badge bg-success">Visible</span>
                @else
                    <span class="badge bg-danger">Hidden</span>
                @endif
            </p>

            {{-- <a href="{{ route('generalinfo.edit', $info->id) }}"
                class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Edit
            </a> --}}

            <form method="POST" action="{{ route('generalinfo.delete', $info->id) }}"
                class="d-inline">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger btn-sm"
                    onclick="return confirm('Are you sure you want to delete this record?')">
                    <i class="fas fa-trash"></i> Delete
                </button>
            </form>
        </div>
    </div>
    @endif

</div>
@endsection
