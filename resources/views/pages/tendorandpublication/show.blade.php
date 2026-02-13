@extends('Dashboard.index')

@section('main-content')
<div class="container-fluid">

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<div class="card shadow">
    <div class="card-header my-sidebar-class text-white d-flex justify-content-between">
        <h4>Tenders List</h4>
        <a href="{{ route('tenders.add') }}" class="btn my-btn-color text-white">+ Add Tender</a>
    </div>

    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Status</th>
                    <th>View</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tenders as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->title }}</td>

                    <!-- STATUS RADIO -->
                    <td>
                        <form action="{{ route('tenders.status',$item->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <input type="radio" name="status" value="new"
                                {{ $item->status == 'new' ? 'checked' : '' }}
                                onchange="this.form.submit()"> New

                            <input type="radio" name="status" value="closed"
                                {{ $item->status == 'closed' ? 'checked' : '' }}
                                onchange="this.form.submit()"> Closed
                        </form>

                        @if($item->status == 'closed')
                            <div class="alert alert-danger mt-2 p-1">
                                Tender is Closed Now
                            </div>
                        @else
                            <div class="alert alert-success mt-2 p-1">
                                Tender Status is New
                            </div>
                        @endif
                    </td>

                    <td>
                        <a href="{{ route('tenders.view',$item->id) }}"
                           class="badge bg-success">VIEW</a>
                    </td>

                    <td>
                        <form action="{{ route('tenders.delete',$item->id) }}"
                              method="POST"
                              onsubmit="return confirm('Delete this tender?')">
                            @csrf
                            @method('DELETE')
                            <button class="badge bg-danger border-0">
                                DELETE
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $tenders->links('pagination::bootstrap-5') }}
    </div>
</div>
</div>
@endsection
