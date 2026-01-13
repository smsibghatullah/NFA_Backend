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
                    @forelse($documents as $doc)
                    <tr>
                        <td>
                            {{ ($documents->currentPage() - 1) * $documents->perPage() + $loop->iteration }}
                        </td>
                        <td>{{ $doc->name }}</td>
                        <td>
                            <a href="{{ route('documents.view',$doc->id) }}"
                                class="badge bg-success px-3 py-2 text-decoration-none">
                                VIEW
                            </a>

                            <form action="{{ route('documents.delete',$doc->id) }}" method="POST"
                                style="display:inline-block"
                                onsubmit="return confirm('Are you sure you want to delete this?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="badge bg-danger border-0 px-3 py-2">
                                    DELETE
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted">
                            No documents found
                        </td>
                    </tr>
                    @endforelse
                </tbody>

            </table>
            <div class="mt-3">
                {{ $documents->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>

        </div>
    </div>
</div>
@endsection
`