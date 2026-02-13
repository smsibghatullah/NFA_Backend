@extends('Dashboard.index')

@section('main-content')

<div class="container-fluid">

    <div class="card shadow border-0">
        <div class="card-header my-sidebar-class text-white">
            <h4 class="mb-0">Edit Vision Content</h4>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('vision.update', $vision->id) }}">
                @csrf
                @method('PUT')

                <div class="form-group mb-4">
                    <label class="my-text-color fw-bold">HTML Content *</label>
                    <textarea class="form-control editor" name="content" required>
                        {!! $vision->content !!}
                    </textarea>
                </div>

                <button type="submit" class="btn my-btn-color text-white">
                    <i class="fas fa-save"></i> Update
                </button>

                <a href="{{ route('vision.index') }}" class="btn btn-secondary">
                    Back
                </a>
            </form>
        </div>
    </div>

</div>

<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<script>
ClassicEditor.create(document.querySelector('.editor')).catch(console.error);
</script>

@endsection
