@php
    // Detect mobile device
    $userAgent = request()->header('User-Agent');
    $isMobile = preg_match('/(android|iphone|ipad|mobile|phone)/i', $userAgent);
@endphp

@if($isMobile)
    @include('posts.create-mobile')
@else
    @include('posts.create-styled')
@endif

@php
    // Stop processing original content
    return;
@endphp

@extends('layouts.portal.view')

    @section('content')
        <div class="container my-4">
            {{-- Page Header --}}
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div>
                    <h1 class="h3 mb-0">📝 Create New Post</h1>
                </div>
                <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-secondary">Back to Posts</a>
            </div>

            {{-- Global errors --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                <strong>There were some issue with your account:</strong>
                <ul class="mb-0">
                    @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
                </ul>
                </div>
            @endif

        @if($author->user_role_id === 1)
            <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
        @else
            <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
        @endif
                @csrf
                {{-- SECTION 1: Content --}}
                <div class="card mb-4 shadow-sm" style="background-color:#fff3e6;">
                <div class="card-header fw-bold text-white" style="background-color:#ff7925;">Content</div>
                <div class="card-body">
                    <div class="mb-3">
                    <label class="form-label fw-semibold">Title of your content <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                            value="{{ old('title') }}" required placeholder="TYPE HERE -> ਲੋੜਵੰਦ ਅਤੇ ਅਨਮੋਲ ਜਾਣਕਾਰੀ, ਜਿਸਨੂੰ ਤੁਸੀਂ ਪ੍ਰਕਾਸ਼ਿਤ ਕਰਨ ਜਾ ਰਹੇ ਹੋ ਉਸ  ਵਾਸਤੇ ਆਕਰਸ਼ਕ ਅਤੇ ਢੁਕਵਾਂ ਸਿਰਲੇਖ ....">
                    @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                    <label class="form-label fw-semibold">Content</label>
                    <small class="text-muted">ਆਪ ਸਭ ਜੀ ਨੂੰ ਬੇਨਤੀ ਹੈ ਕਿ ਥਲ੍ਹੇ ਦਿਤੇ ਬਾਕਸ ਵਿੱਚ ਆਪਣੀ ਅਨਮੋਲ ਜਾਣਕਾਰੀ ਨੂੰ ਪ੍ਰਕਾਸ਼ਿਤ ਕਰਨ ਵਾਸਤੇ ਸਾਫ ਸੁਥਰੇ ਅਤੇ ਮਰਿਆਦਤ ਸ਼ਬਦਾਂ ਦਾ ਪ੍ਰਯੋਗ ਕਰੋ।</small>
                    <textarea name="content" class="form-control tinymce @error('content') is-invalid @enderror" rows="10">{{ old('content') }}</textarea>
                    @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                </div>

                {{-- SECTION 2: Media --}}
                <div class="card mb-4 shadow-sm" style="background-color:#fff0e1;">
                <div class="card-header fw-bold text-white" style="background-color:#e65c00;">Media</div>
                <div class="card-body">
                    <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold" for="postImageInput">ਢੁਕਵੀਂ ਫੋਟੋ</label>
                        <input type="file"
                            id="postImageInput"
                            name="image"
                            class="form-control @error('image') is-invalid @enderror"
                            accept="image/*">
                        @error('image') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror

                        <div class="form-text">Recommended: 1200×630px (max ~2–3MB). JPG/PNG/WebP.</div>

                        <div class="d-flex gap-2 mt-2">
                        <button type="button" id="postImageRemove" class="btn btn-sm btn-outline-danger d-none">Remove</button>
                        <span id="postImageMeta" class="small text-muted d-none"></span>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="image-preview-wrap border rounded p-2 text-center">
                        <img id="postImagePreview" alt="Preview" class="img-fluid rounded d-none">
                        <div id="postImagePlaceholder" class="text-muted small">No image selected</div>
                        </div>
                    </div>
                    </div>

                    {{-- PDF Embed Fields --}}
                    <div class="row g-3 mt-3">
                    <div class="col-12">
                        <hr class="my-3">
                        <h6 class="fw-semibold mb-3">📄 PDF Document (Optional)</h6>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold" for="pdfUrl">PDF URL (Google Drive/Direct Link)</label>
                        <input type="url"
                            id="pdfUrl"
                            name="pdf_url"
                            class="form-control @error('pdf_url') is-invalid @enderror"
                            value="{{ old('pdf_url') }}"
                            placeholder="https://drive.google.com/file/d/...">
                        @error('pdf_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <div class="form-text">Paste unrestricted Google Drive or direct PDF link</div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold" for="pdfTitle">PDF Title (Optional)</label>
                        <input type="text"
                            id="pdfTitle"
                            name="pdf_title"
                            class="form-control @error('pdf_title') is-invalid @enderror"
                            value="{{ old('pdf_title') }}"
                            placeholder="e.g., Download Full Report">
                        @error('pdf_title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <div class="form-text">Display name for the PDF section</div>
                    </div>
                    </div>
                </div>
                </div>

                {{-- SECTION 3: SEO --}}
                <div class="card mb-4" style="background-color:#fff3e6;">
                    <div class="card-header fw-bold bg-warning">
                    3)  SEO Settings
                    </div>
                    <div class="card-body">

                        {{-- Input fields --}}
                        <div class="mb-3">
                            <label for="meta_title" class="form-label">Meta Title</label>
                            <input type="text" id="meta_title" name="meta_title" class="form-control"
                                    value="{{ old('meta_title', $directory->meta_title ?? '') }}"
                                    maxlength="255"
                                    oninput="updateSeoPreview()">
                        </div>

                        <div class="mb-3">
                            <label for="meta_description" class="form-label">Meta Description</label>
                            <textarea id="meta_description" name="meta_description" rows="2" class="form-control"
                                        maxlength="255"
                                        oninput="updateSeoPreview()">{{ old('meta_description', $directory->meta_description ?? '') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="meta_keywords" class="form-label">Meta Keywords</label>
                            <input type="text" id="meta_keywords" name="meta_keywords" class="form-control"
                                    value="{{ old('meta_keywords', $directory->meta_keywords ?? '') }}"
                                    maxlength="255">
                            <small class="text-muted">Separate with commas</small>
                        </div>

                        {{-- Google result preview --}}
                        <div id="serpPreview" class="serp serp--mobile border rounded p-2">
                            <div class="serp__site d-flex align-items-center gap-2 text-muted">
                                <img src="{{ asset('favicon.ico') }}" class="rounded" style="width:16px;height:16px" alt="">
                                <span>{{ config('app.url') ?? request()->getHost() }}</span>
                                <span class="text-muted">›</span>
                                <span id="pv-slug" class="text-muted">{{ request()->path() }}</span>
                            </div>

                            <div id="pv-title" class="serp__title fw-bold text-primary mt-1">
                                {{ old('meta_title', $directory->meta_title ?? 'Your SEO Title Will Appear Here') }}
                            </div>

                            <div class="d-flex align-items-start gap-2 mt-1">
                                <div id="pv-desc" class="serp__desc text-muted">
                                    {{ old('meta_description', $directory->meta_description ?? 'Your meta description preview will show here. Keep it concise and compelling.') }}
                                </div>
                            </div>

                            <div class="serp__meta small text-muted mt-1">
                                <span id="pv-date">{{ now()->format('M d, Y') }}</span> — <span id="pv-snippet-inline"></span>
                            </div>
                        </div>

                        <div class="mt-3 d-flex gap-3 align-items-center">
                            <small id="count-title" class="text-muted">Title: {{ strlen(old('meta_title', $directory->meta_title ?? '')) }}/60</small>
                            <small id="count-desc" class="text-muted">Description: {{ strlen(old('meta_description', $directory->meta_description ?? '')) }}/155</small>
                        </div>
                    </div>
                </div>


                {{-- SECTION 4: Categories & Tags --}}
                <div class="card mb-4">
                <div class="card-header bg-light">
                    <h2 class="h6 mb-0">4) Categories & Tags</h2>
                </div>
                <div class="card-body" style="background-color:#fffaf0;">
                    <div class="mb-3">
                    <label class="form-label fw-semibold">Categories</label>
                    <select name="categories[]" class="form-select @error('categories') is-invalid @enderror" multiple size="6">
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ collect(old('categories'))->contains($category->id) ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('categories') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    <div class="form-text">Hold Ctrl/Cmd to select multiple.</div>
                    </div>

                    <div class="mb-3">
                    <label class="form-label fw-semibold">Tags</label>
                    <select name="tags[]" class="form-select @error('tags') is-invalid @enderror" multiple size="6">
                        @foreach($tags as $tag)
                        <option value="{{ $tag->id }}" {{ collect(old('tags'))->contains($tag->id) ? 'selected' : '' }}>
                            {{ $tag->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('tags') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>
                </div>
                </div>
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
                    <input type="hidden" name="status" value="draft">
                @endif
                {{-- Actions --}}
                <div class="d-flex justify-content-between align-items-center border-top pt-3 pb-4">
                <small class="text-muted">Save your work when you’re happy.</small>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
                </div>
            </form>
        </div>

    @endsection

    @push('styles')
    <style>
    .image-preview-wrap{
        display:flex;align-items:center;justify-content:center
    }
    #postImagePreview{max-height:200px;max-width:100%;object-fit:contain;display:block}
    </style>
    @endpush


    @push('scripts')
    <script src="{{ asset('tinymce/js/tinymce/tinymce.min.js') }}"></script>

    <script>
    // --- TinyMCE (wrap in try/catch so errors don't kill the page) ---
    document.addEventListener('DOMContentLoaded', function () {
    try {
        tinymce.init({
        selector: 'textarea.tinymce',
        height: 500,
        menubar: true,

        // ✅ Only keep plugins that exist in TinyMCE 7 and that you actually ship
        plugins: 'preview paste importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media codesample table charmap anchor toc insertdatetime advlist lists wordcount textpattern help quickbars',

        // ❌ Removed/legacy: print, template, imagetools, noneditable (remove them)
        // If you don't use 'toc' or others, remove them too.

        toolbar: 'undo redo | formatselect | fontsizeselect | fontselect | forecolor backcolor | ' +
                'bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | ' +
                'outdent indent | numlist bullist | link image media | preview code',

        // Licensing
        license_key: 'gpl',   // Or your paid license key string

        content_css: '{{ asset('css/tinymce-content.css') }}',
        font_formats: 'Arial=arial,helvetica,sans-serif; Courier New=courier new,courier; Times New Roman=times new roman,times; Verdana=verdana,geneva;',
        fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt 48pt',
        content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
        relative_urls: false,
        remove_script_host: false,

        // If you really need image upload in the editor:
        images_upload_url: '{{ route('tinymce.upload') }}',
        automatic_uploads: true,
        file_picker_types: 'image',
        images_upload_handler: function (blobInfo, success, failure) {
            const xhr = new XMLHttpRequest();
            xhr.withCredentials = false;
            xhr.open('POST', '{{ route('tinymce.upload') }}');
            xhr.setRequestHeader('X-CSRF-Token', '{{ csrf_token() }}');
            xhr.onload = function () {
            if (xhr.status !== 200) { failure('HTTP Error: ' + xhr.status); return; }
            let json = {};
            try { json = JSON.parse(xhr.responseText); } catch (e) {}
            if (!json || typeof json.location !== 'string') {
                failure('Invalid JSON: ' + xhr.responseText);
                return;
            }
            success(json.location);
            };
            const formData = new FormData();
            formData.append('file', blobInfo.blob(), blobInfo.filename());
            xhr.send(formData);
        }
        });
    } catch (e) {
        console.error('[TinyMCE init error]', e);
    }
    });
    </script>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
    const qs  = (s,sc=document) => sc.querySelector(s);
    const log = (...a)=>console.log('[MediaPreview]',...a);

    const input   = qs('#postImageInput');
    const preview = qs('#postImagePreview');
    const holder  = qs('#postImagePlaceholder');
    const btnRm   = qs('#postImageRemove');
    const meta    = qs('#postImageMeta');

    if (!input || !preview || !holder) {
        console.warn('[MediaPreview] Missing elements:', {input:!!input, preview:!!preview, holder:!!holder});
        return;
    }

    function resetPreview() {
        log('reset');
        preview.removeAttribute('src');
        preview.classList.add('d-none');
        holder.classList.remove('d-none');
        btnRm && btnRm.classList.add('d-none');
        meta && meta.classList.add('d-none');
        // Don’t forcibly clear input; user might want to keep selection.
        // input.value = '';
    }

    function showPreview(file) {
        if (!file || !file.type.startsWith('image/')) { resetPreview(); return; }
        log('file selected:', file.name, file.type, file.size);

        const done = (src) => {
        preview.src = src;
        preview.classList.remove('d-none');
        holder.classList.add('d-none');
        btnRm && btnRm.classList.remove('d-none');
        if (meta) {
            const sizeKB = (file.size / 1024).toFixed(1);
            meta.textContent = `${file.name} • ${sizeKB} KB`;
            meta.classList.remove('d-none');
        }
        };

        // Prefer FileReader; fallback to object URL.
        try {
        const reader = new FileReader();
        reader.onload = e => done(e.target.result);
        reader.readAsDataURL(file);
        } catch (e) {
        log('FileReader failed, fallback to object URL', e);
        const url = URL.createObjectURL(file);
        done(url);
        preview.onload = () => URL.revokeObjectURL(url);
        }
    }

    // Event delegation to survive DOM changes / duplicate inputs
    document.addEventListener('change', function (e) {
        if (e.target && e.target.matches('#postImageInput')) {
        const file = e.target.files && e.target.files[0];
        if (!file) { resetPreview(); return; }
        showPreview(file);
        }
    });

    btnRm && btnRm.addEventListener('click', resetPreview);

    // If the server repopulates an existing image (edit page), call showPreview with a Blob? Else ignore.
    });
    </script>

    <script>
    // --- SEO live counters (unchanged) ---
    function updateSeoPreview(){
    const t=document.getElementById('meta_title')?.value||'';
    const d=document.getElementById('meta_description')?.value||'';
    const pvTitle=document.getElementById('pv-title');
    const pvDesc=document.getElementById('pv-desc');
    pvTitle && (pvTitle.innerText = t || 'Your SEO Title Will Appear Here');
    pvDesc  && (pvDesc.innerText = d || 'Your meta description preview will show here. Keep it concise and compelling.');
    const cT=document.getElementById('count-title');
    const cD=document.getElementById('count-desc');
    cT && (cT.innerText=`Title: ${t.length}/60`);
    cD && (cD.innerText=`Description: ${d.length}/155`);
    }
    </script>
    @endpush


