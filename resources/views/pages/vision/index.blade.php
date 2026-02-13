@extends('Dashboard.index')

@section('main-content')

<div class="container-fluid">

    {{-- FORM CARD --}}
    <div class="card shadow border-0 mb-4">
        <div class="card-header my-sidebar-class text-white">
            <h4 class="mb-0">Add Vision Content</h4>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('vision.store') }}">
                @csrf

                <div class="form-group mb-4">
                    <label class="my-text-color fw-bold">HTML Content *</label>
                    <textarea
                        class="form-control editor"
                        name="content"
                        placeholder="Write vision content here..."
                    ></textarea>
                </div>

                <button type="submit" class="btn my-btn-color text-white px-4">
                    <i class="fas fa-save"></i> Save Content
                </button>
            </form>
        </div>
    </div>

    {{-- TABLE CARD --}}
    <div class="card shadow border-0">
        <div class="card-header my-sidebar-class text-white">
            <h4 class="mb-0">Saved Vision Records</h4>
        </div>

        <div class="card-body">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Content</th>
                        <th width="180">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($visions as $vision)
                        <tr>
                            <td>
                                {!! \Illuminate\Support\Str::limit(strip_tags($vision->content), 200, '...') !!}
                                @if(strlen(strip_tags($vision->content)) > 200)
                                    <a href="javascript:void(0)"
                                       class="text-primary viewBtn"
                                       data-id="{{ $vision->id }}">
                                        Read More
                                    </a>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('vision.edit', $vision->id) }}"
                                   class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i> Edit
                                </a>

                                <button class="btn btn-sm btn-danger deleteBtn"
                                        data-id="{{ $vision->id }}">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center text-muted">
                                No records found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- VIEW MODAL --}}
<div class="modal fade" id="viewModal">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header my-sidebar-class text-white">
                <h5 class="modal-title">Vision Content</h5>
                <button type="button"
                        class="btn-close btn-close-white"
                        data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="modalBody"></div>
        </div>
    </div>
</div>

{{-- SCRIPTS --}}
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>

<script>
ClassicEditor
.create(document.querySelector('.editor'), {
    toolbar: [
        'heading',
        '|',
        'bold',
        'italic',
        'underline',
        'link',
        '|',
        'bulletedList',
        'numberedList',
        '|',
        'insertTable',
        '|',
        'undo',
        'redo'
    ]
})
.catch(error => console.error(error));

$(document).on('click', '.viewBtn', function () {
    let id = $(this).data('id');

    $.get('/vision/' + id, function (res) {
        $('#modalBody').html(res.content);

        let modal = new bootstrap.Modal(
            document.getElementById('viewModal')
        );
        modal.show();
    });
});

$(document).on('click', '.deleteBtn', function () {
    let id = $(this).data('id');

    if (confirm('Are you sure you want to delete this record?')) {
        $.ajax({
            url: '/vision/' + id,
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
