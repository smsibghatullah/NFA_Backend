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
<td>
    {{ ($downloads->currentPage() - 1) * $downloads->perPage() + $loop->iteration }}
</td>
                        <td>{{ $item->name }}</td>
                       <td>
    <a href="{{ route('downloads.view',$item->id) }}"
       class="badge bg-success px-3 py-2 text-decoration-none">
        VIEW
    </a>

    <form action="{{ route('downloads.delete',$item->id) }}"
          method="POST"
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
                    @endforeach
                </tbody>
            </table>
            <div class="mt-3">
    {{ $downloads->appends(request()->query())->links('pagination::bootstrap-5') }}
</div>

        </div>
    </div>
</div>
@endsection
