@extends('Dashboard.index')

@section('main-content')
<div class="container-fluid">
    <div class="card shadow">
        <div class="card-header my-sidebar-class text-white">
            <h4>{{ $tender->title }}</h4>
        </div>

        <div class="card-body">
            <iframe src="{{ asset('uploads/tenders/'.$tender->file) }}"
                    width="100%" height="600px"></iframe>
        </div>
    </div>
</div>
@endsection
