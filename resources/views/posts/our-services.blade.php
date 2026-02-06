@extends('Dashboard.index')

@section('main-content')

<div class="container-fluid">

    {{-- FORM CARD --}}
    <div class="card shadow border-0 mb-4">
        <div class="card-header my-sidebar-class text-white">
            <h4 class="mb-0">Add Service</h4>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('services.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="form-group mb-3">
                    <label class="my-text-color fw-bold">Title *</label>
                    <input type="text" class="form-control" name="title" placeholder="Enter service title" required>
                </div>

                <div class="form-group mb-3">
                    <label class="my-text-color fw-bold">Image</label>
                    <input type="file" class="form-control" name="image">
                </div>

                <div class="form-group mb-4">
                    <label class="my-text-color fw-bold">HTML Content *</label>
                    <textarea class="form-control editor" name="content"
                        placeholder="Write content here..."></textarea>
                </div>

                <button type="submit" class="btn my-btn-color text-white px-4">
                    <i class="fas fa-save"></i> Save Service
                </button>
            </form>
        </div>
    </div>

    {{-- TABLE CARD --}}
    <div class="card shadow border-0">
        <div class="card-header my-sidebar-class text-white">
            <h4 class="mb-0">Saved Services</h4>
        </div>

        <div class="card-body">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Title</th>
                        <th width="200">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($services as $service)
                        <tr>
                            <td>{{ $service->title }}</td>
                            <td>
                                <button class="btn btn-sm btn-primary viewBtn" data-id="{{ $service->id }}">
                                    <i class="fas fa-eye"></i> View
                                </button>

                                <button class="btn btn-sm btn-danger deleteBtn" data-id="{{ $service->id }}">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center text-muted">No services found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- MODAL --}}
<div class="modal fade" id="viewModal">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header my-sidebar-class text-white">
                <h5 class="modal-title">View Service</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="modalBody"></div>
        </div>
    </div>
</div>

{{-- CKEditor & Scripts --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>

<script>
ClassicEditor
.create(document.querySelector('.editor'), {
    toolbar: [
        'heading','|','bold','italic','underline','link','|',
        'bulletedList','numberedList','|','outdent','indent','insertTable','|',
        'undo','redo'
    ]
})
.catch(error => console.error(error));

// VIEW MODAL
$(document).on('click', '.viewBtn', function () {
    let id = $(this).data('id');

    $.get('/services/' + id, function (res) {
        $('#modalBody').html(`
            <h4 class="mb-3">${res.title}</h4>
            ${res.image ? `<img src="/storage/${res.image}" class="img-fluid mb-3 rounded">` : ``}
            <div>${res.content}</div>
        `);

        let modal = new bootstrap.Modal(document.getElementById('viewModal'));
        modal.show();
    });
});

// DELETE SERVICE
$(document).on('click', '.deleteBtn', function () {
    let id = $(this).data('id');

    if (confirm('Are you sure you want to delete this service?')) {
        $.ajax({
            url: '/services/' + id,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function () {
                location.reload();
            }
        });
    }
});
</script>

@endsection
