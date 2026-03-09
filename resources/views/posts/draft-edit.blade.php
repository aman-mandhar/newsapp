@extends('layouts.dashboard.promotor.layout')

@section('content')
<div class="container">
    <h1 class="mb-4">✏️ Edit Post</h1>

    <form action="{{ route('admin.posts.update', $post) }}" method="POST" enctype="multipart/form-data" class="border p-4 rounded shadow-sm">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="fw-bold">Title</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $post->title) }}" required>
            @error('title') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="fw-bold">Content</label>
            <textarea name="content" class="form-control tinymce" rows="6">{{ old('content', $post->content) }}</textarea>
            @error('content') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="fw-bold">Image Upload</label>
            <input type="file" name="image" class="form-control" id="imageInput">
            <div class="mt-3">
                <img id="imagePreview" src="{{ $post->image_path ? asset('storage/' . $post->image_path) : asset('images/no-preview.png') }}" alt="Image Preview" style="max-height: 200px;">
            </div>
            @error('image') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <script>
            document.getElementById('imageInput').addEventListener('change', function(event) {
                const [file] = this.files;
                const preview = document.getElementById('imagePreview');
                if (file) {
                    preview.src = URL.createObjectURL(file);
                    preview.style.display = 'block';
                } else {
                    preview.src = "{{ asset('images/no-preview.png') }}";
                    preview.style.display = 'none';
                }
            });
        </script>

        <hr>

        <div class="row">
            @if($author->user_role_id === 1)
                    <div class="mb-3">
                        <label class="form-label fw-bold">Status</label>
                        <select name="status" class="form-control">
                            @foreach($statuses as $status)
                                <option value="{{ $status }}" {{ old('status') == $status ? 'selected' : '' }}>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
            @else
                <label class="form-label fw-bold">Status : {{ $post->status }}</label>
                <input type="hidden" name="status" value="draft">
            @endif

            <div class="col-md-6 mb-3">
                <label class="fw-bold">Publish Date</label>
                <input type="datetime-local" name="published_at" class="form-control"
                       value="{{ old('published_at', optional($post->published_at)->format('Y-m-d\TH:i')) }}">
                @error('published_at') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
        </div>

        <hr>

        <div class="mb-3">
            <label class="fw-bold">Meta Title</label>
            <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title', $post->meta_title) }}">
            @error('meta_title') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="fw-bold">Meta Description</label>
            <input type="text" name="meta_description" class="form-control" value="{{ old('meta_description', $post->meta_description) }}">
            @error('meta_description') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="fw-bold">Meta Keywords</label>
            <input type="text" name="meta_keywords" class="form-control" value="{{ old('meta_keywords', $post->meta_keywords) }}">
            @error('meta_keywords') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <hr>

        <div class="mb-3">
            <label class="fw-bold">Categories</label>
            <select name="categories[]" class="form-control" multiple>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ in_array($category->id, old('categories', $post->categories->pluck('id')->toArray())) ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('categories') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="fw-bold">Tags</label>
            <select name="tags[]" class="form-control" multiple>
                @foreach($tags as $tag)
                    <option value="{{ $tag->id }}"
                        {{ in_array($tag->id, old('tags', $post->tags->pluck('id')->toArray())) ? 'selected' : '' }}>
                        {{ $tag->name }}
                    </option>
                @endforeach
            </select>
            @error('tags') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script src="{{ asset('tinymce/js/tinymce/tinymce.min.js') }}"></script>
<script>
window.onload = function() {
    tinymce.init({
        selector: 'textarea.tinymce',
        height: 500,
        menubar: true,
        plugins: 'print preview paste importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars emoticons',
        toolbar: 'undo redo | formatselect | fontsizeselect | fontselect | forecolor backcolor | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | outdent indent | numlist bullist | link image media | preview code',
        content_css: '{{ asset('css/tinymce-content.css') }}',
        font_formats: 'Arial=arial,helvetica,sans-serif; Courier New=courier new,courier; Times New Roman=times new roman,times; Verdana=verdana,geneva;',
        fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt 48pt',
        content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
        relative_urls: false,
        remove_script_host: false,

        images_upload_url: '{{ route('tinymce.upload') }}',
        automatic_uploads: true,
        file_picker_types: 'image',
        images_upload_handler: function (blobInfo, success, failure) {
            var xhr = new XMLHttpRequest();
            xhr.withCredentials = false;
            xhr.open('POST', '{{ route('tinymce.upload') }}');
            xhr.setRequestHeader("X-CSRF-Token", '{{ csrf_token() }}');
            xhr.onload = function() {
                var json;
                if (xhr.status != 200) {
                    failure('HTTP Error: ' + xhr.status);
                    return;
                }
                json = JSON.parse(xhr.responseText);
                if (!json || typeof json.location != 'string') {
                    failure('Invalid JSON: ' + xhr.responseText);
                    return;
                }
                success(json.location);
            };
            var formData = new FormData();
            formData.append('file', blobInfo.blob(), blobInfo.filename());
            xhr.send(formData);
        }
    });
};
</script>
@endpush
