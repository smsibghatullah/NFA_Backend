@extends('Dashboard.index')

@section('main-content')
<div class="container-fluid">
    <div class="card shadow">
        <div class="card-header my-sidebar-class text-white d-flex justify-content-between">
            <h4 class="mb-0">Download Forms</h4>
            <a href="{{ route('downloads.add') }}" class="btn my-btn-color text-white">
                + Add Form
            </a>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Form Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($downloads as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->name }}</td>
                        <td>
                            <a href="{{ route('downloads.view',$item->id) }}"
                               class="badge bg-success px-3 py-2 text-decoration-none">
                                VIEW
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
