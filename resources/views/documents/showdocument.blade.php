@extends('Dashboard.index')

@section('main-content')
<div class="container-fluid">
    <div class="card shadow">
        <div class="card-header my-sidebar-class text-white d-flex justify-content-between">
            <h4 class="mb-0">Documents List</h4>
            <a href="{{ route('documents.add') }}" class="btn my-btn-color text-white">
                + Add Document
            </a>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Document Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($documents as $doc)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $doc->name }}</td>
                        <td>
                            <a href="{{ route('documents.view',$doc->id) }}"
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
`