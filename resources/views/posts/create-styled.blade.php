@extends('layouts.portal.view')

@push('styles')
<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

:root {
    --primary-color: #000000;
    --secondary-color: #FF0000;
    --accent-color: #FAF2AC;
    --dark-color: #000000;
    --light-bg: #FAF2AC;
    --gradient-1: #000000;
    --gradient-2: #000000;
    --gradient-3: #000000;
    --gradient-4: #000000;
    --shadow-sm: 0 2px 8px rgba(0,0,0,0.08);
    --shadow-md: 0 4px 16px rgba(0,0,0,0.12);
    --shadow-lg: 0 8px 24px rgba(0,0,0,0.15);
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #FAF2AC;
    min-height: 100vh;
    padding: 20px 0;
    color: #000000;
}

.create-post-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 15px;
}

/* Header Styling */
.page-header {
    background: white;
    border-radius: 20px;
    padding: 30px;
    margin-bottom: 30px;
    box-shadow: var(--shadow-lg);
    display: flex;
    justify-content: space-between;
    align-items: center;
    animation: slideDown 0.5s ease;
}

.page-header h1 {
    font-size: 2rem;
    color: #FF0000;
    font-weight: 700;
    margin: 0;
}

.btn-back {
    background: #000000;
    color: white;
    border: none;
    padding: 12px 24px;
    border-radius: 50px;
    font-weight: 600;
    text-decoration: none;
    transition: transform 0.3s, box-shadow 0.3s;
    box-shadow: var(--shadow-sm);
}

.btn-back:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-md);
    color: white;
}

/* Alert Styling */
.alert-custom {
    background: white;
    border-left: 4px solid #FF0000;
    border-radius: 15px;
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: var(--shadow-md);
    animation: slideRight 0.5s ease;
}

.alert-custom strong {
    color: #FF0000;
    font-size: 1.1rem;
}

/* Card Styling */
.card-custom {
    background: white;
    border-radius: 20px;
    margin-bottom: 30px;
    overflow: hidden;
    box-shadow: var(--shadow-lg);
    transition: transform 0.3s;
    animation: fadeInUp 0.6s ease;
}

.card-custom:hover {
    transform: translateY(-5px);
}

.card-header-custom {
    padding: 20px 30px;
    background: #000000;
    color: white;
    font-weight: 700;
    font-size: 1.3rem;
    display: flex;
    align-items: center;
    gap: 10px;
}

.card-header-custom.gradient-1,
.card-header-custom.gradient-2,
.card-header-custom.gradient-3,
.card-header-custom.gradient-4 {
    background: #000000;
}

.card-body-custom {
    padding: 30px;
}

/* Form Elements */
.form-group-custom {
    margin-bottom: 25px;
}

.form-label-custom {
    font-weight: 600;
    color: #FF0000;
    margin-bottom: 8px;
    display: block;
    font-size: 1rem;
}

.form-control-custom {
    width: 100%;
    padding: 12px 18px;
    border: 2px solid #000000;
    border-radius: 12px;
    font-size: 1rem;
    transition: all 0.3s;
    background: white;
    color: #000000;
}

.form-control-custom:focus {
    outline: none;
    border-color: #FF0000;
    background: white;
    box-shadow: 0 0 0 4px rgba(255, 0, 0, 0.1);
}

.form-text-custom {
    color: #000000;
    font-size: 0.875rem;
    margin-top: 5px;
    display: block;
}

/* Image Preview */
.image-preview-container {
    border: 3px dashed #000000;
    border-radius: 15px;
    padding: 20px;
    text-align: center;
    background: white;
    transition: all 0.3s;
    min-height: 200px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.image-preview-container:hover {
    border-color: #FF0000;
    background: #FFFEF5;
}

#postImagePreview {
    max-height: 300px;
    max-width: 100%;
    border-radius: 12px;
    box-shadow: var(--shadow-md);
}

#postImagePlaceholder {
    color: #000000;
    font-size: 1.1rem;
}

/* Buttons */
.btn-remove {
    background: #FF0000;
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 25px;
    font-size: 0.875rem;
    font-weight: 600;
    transition: transform 0.2s;
}

.btn-remove:hover {
    transform: scale(1.05);
}

/* SEO Preview */
.serp-preview {
    background: white;
    border: 2px solid #000000;
    border-radius: 15px;
    padding: 20px;
    margin-top: 20px;
}

.serp__title {
    color: #FF0000;
    font-size: 1.25rem;
    font-weight: 600;
    margin: 8px 0;
}

.serp__desc {
    color: #000000;
    font-size: 0.95rem;
    line-height: 1.6;
}

/* Action Buttons */
.action-container {
    background: white;
    padding: 25px 30px;
    border-radius: 20px;
    box-shadow: var(--shadow-lg);
    margin-top: 30px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}



.btn-cancel {
    background: white;
    color: #000000;
    border: 2px solid #000000;
    padding: 12px 30px;
    border-radius: 50px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s;
    display: inline-block;
}

.btn-cancel:hover {
    background: #F0F0F0;
    transform: translateY(-2px);
}

.btn-submit {
    background: #000000;
    color: white;
    border: none;
    padding: 12px 40px;
    border-radius: 50px;
    font-weight: 700;
    font-size: 1.1rem;
    transition: all 0.3s;
    box-shadow: var(--shadow-md);
}

.btn-submit:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-lg);
}

/* Animations */
@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slideRight {
    from {
        opacity: 0;
        transform: translateX(-30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

/* Select Styling */
.form-select-custom {
    width: 100%;
    padding: 12px 18px;
    border: 2px solid #000000;
    border-radius: 12px;
    font-size: 1rem;
    background: white;
    min-height: 150px;
    color: #000000;
}

.form-select-custom:focus {
    outline: none;
    border-color: #FF0000;
    box-shadow: 0 0 0 4px rgba(255, 0, 0, 0.1);
}

/* Checkbox List Styling */
.checkbox-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 12px;
    max-height: 300px;
    overflow-y: auto;
    padding: 15px;
    border: 2px solid #000000;
    border-radius: 12px;
    background: white;
}

.checkbox-item {
    display: flex;
    align-items: center;
    padding: 12px 15px;
    background: #FAF2AC;
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.3s;
    border: 2px solid #000000;
}

.checkbox-item:hover {
    background: #F0E89D;
    border-color: #FF0000;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.checkbox-item input[type="checkbox"],
.checkbox-item input[type="radio"] {
    width: 18px;
    height: 18px;
    margin-right: 10px;
    cursor: pointer;
    accent-color: #000000;
}

.checkbox-item label {
    flex: 1;
    margin: 0;
    cursor: pointer;
    font-size: 0.95rem;
    color: #000000;
    font-weight: 500;
}

.checkbox-item input[type="checkbox"]:checked + label,
.checkbox-item input[type="radio"]:checked + label {
    color: #FF0000;
    font-weight: 600;
}

/* Required Asterisk */
.required {
    color: #FF0000;
    font-weight: bold;
}

/* PDF Section */
.pdf-section {
    background: white;
    border: 2px solid #000000;
    padding: 20px;
    border-radius: 15px;
    margin-top: 20px;
}

.pdf-section h6 {
    color: #FF0000;
    font-weight: 700;
}

/* Status Badge */
.status-indicator {
    display: inline-block;
    padding: 8px 20px;
    border-radius: 25px;
    font-weight: 600;
    font-size: 0.9rem;
}

.status-draft {
    background: #ffeaa7;
    color: #fdcb6e;
}

/* Responsive */
@media (max-width: 768px) {
    .page-header {
        flex-direction: column;
        gap: 15px;
        text-align: center;
    }

    .page-header h1 {
        font-size: 1.5rem;
    }

    .card-header-custom {
        font-size: 1.1rem;
        padding: 15px 20px;
    }

    .card-body-custom {
        padding: 20px;
    }

    .action-container {
        flex-direction: column;
        gap: 15px;
    }

    .btn-submit, .btn-cancel {
        width: 100%;
        text-align: center;
    }
}
</style>
@endpush

@section('content')
<div class="create-post-container">
    {{-- Page Header --}}
    <div class="page-header">
        <div>
            <h1>📝 Create New Post</h1>
        </div>
        <a href="{{ route('admin.posts.index') }}" class="btn-back">✖ Go Back</a>
    </div>

    {{-- Global errors --}}
    @if ($errors->any())
        <div class="alert-custom">
            <strong>⚠️ There are some errors:</strong>
            <ul class="mb-0 mt-2">
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
        <div class="card-custom" style="animation-delay: 0.1s;">
            <div class="card-header-custom gradient-1">
                <span>✍️</span> 1) Content
            </div>
            <div class="card-body-custom">
                <div class="form-group-custom">
                    <label class="form-label-custom">Title <span class="required">*</span></label>
                    <input type="text" name="title" class="form-control-custom @error('title') is-invalid @enderror"
                           value="{{ old('title') }}" required
                           placeholder="Write an attractive title here...">
                    @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="form-group-custom">
                    <label class="form-label-custom">Content</label>
                    <small class="form-text-custom">Please use clear and respectful words.</small>
                    <textarea name="content" class="form-control-custom tinymce @error('content') is-invalid @enderror" rows="10">{{ old('content') }}</textarea>
                    @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>

        {{-- SECTION 2: Media --}}
        <div class="card-custom" style="animation-delay: 0.2s;">
            <div class="card-header-custom gradient-2">
                <span>🖼️</span> 2) Media
            </div>
            <div class="card-body-custom">
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label-custom" for="postImageInput">Upload Photo</label>
                        <input type="file"
                               id="postImageInput"
                               name="image"
                               class="form-control-custom @error('image') is-invalid @enderror"
                               accept="image/*">
                        @error('image') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror

                        <small class="form-text-custom">Recommended: 1200×630px (maximum 2-3MB). JPG/PNG/WebP</small>

                        <div class="d-flex gap-2 mt-3">
                            <button type="button" id="postImageRemove" class="btn-remove d-none">Remove</button>
                            <span id="postImageMeta" class="small text-muted d-none"></span>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="image-preview-container">
                            <img id="postImagePreview" alt="Preview" class="d-none">
                            <div id="postImagePlaceholder">📷 No photo selected</div>
                        </div>
                    </div>
                </div>

                {{-- PDF Section --}}
                <div class="pdf-section">
                    <h6 class="mb-3">📄 PDF Document (Optional)</h6>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label-custom" for="pdfUrl">PDF URL (Google Drive/Direct Link)</label>
                            <input type="url"
                                   id="pdfUrl"
                                   name="pdf_url"
                                   class="form-control-custom @error('pdf_url') is-invalid @enderror"
                                   value="{{ old('pdf_url') }}"
                                   placeholder="https://drive.google.com/file/d/...">
                            @error('pdf_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <small class="form-text-custom">Paste unlimited Google Drive or direct PDF link</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-custom" for="pdfTitle">PDF Title (Optional)</label>
                            <input type="text"
                                   id="pdfTitle"
                                   name="pdf_title"
                                   class="form-control-custom @error('pdf_title') is-invalid @enderror"
                                   value="{{ old('pdf_title') }}"
                                   placeholder="Example: Download Full Report">
                            @error('pdf_title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <small class="form-text-custom">Display name for PDF section</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- SECTION 3: SEO --}}
        <div class="card-custom" style="animation-delay: 0.3s;">
            <div class="card-header-custom gradient-3">
                <span>🔍</span> 3) SEO Settings
            </div>
            <div class="card-body-custom">
                <div class="form-group-custom">
                    <label for="meta_title" class="form-label-custom">Meta Title</label>
                    <input type="text" id="meta_title" name="meta_title" class="form-control-custom"
                           value="{{ old('meta_title', $directory->meta_title ?? '') }}"
                           maxlength="255"
                           oninput="updateSeoPreview()"
                           placeholder="Attractive title for SEO">
                </div>

                <div class="form-group-custom">
                    <label for="meta_description" class="form-label-custom">Meta Description</label>
                    <textarea id="meta_description" name="meta_description" rows="3" class="form-control-custom"
                              maxlength="255"
                              oninput="updateSeoPreview()"
                              placeholder="Write a brief and attractive description...">{{ old('meta_description', $directory->meta_description ?? '') }}</textarea>
                </div>

                <div class="form-group-custom">
                    <label for="meta_keywords" class="form-label-custom">Meta Keywords</label>
                    <input type="text" id="meta_keywords" name="meta_keywords" class="form-control-custom"
                           value="{{ old('meta_keywords', $directory->meta_keywords ?? '') }}"
                           maxlength="255"
                           placeholder="keyword1, keyword2, keyword3">
                    <small class="form-text-custom">Separate with commas</small>
                </div>

                {{-- Google Preview --}}
                <div class="serp-preview">
                    <div class="serp__site d-flex align-items-center gap-2 text-muted small">
                        <img src="{{ asset('favicon.ico') }}" style="width:16px;height:16px" alt="">
                        <span>{{ config('app.url') ?? request()->getHost() }}</span>
                    </div>

                    <div id="pv-title" class="serp__title">
                        {{ old('meta_title', $directory->meta_title ?? 'Your SEO title will appear here') }}
                    </div>

                    <div id="pv-desc" class="serp__desc">
                        {{ old('meta_description', $directory->meta_description ?? 'Your meta description will appear here. Keep it brief and attractive.') }}
                    </div>

                    <div class="serp__meta small text-muted mt-2">
                        <span id="pv-date">{{ now()->format('d M, Y') }}</span>
                    </div>
                </div>

                <div class="mt-3 d-flex gap-3 align-items-center">
                    <small id="count-title" class="text-muted">Title: {{ strlen(old('meta_title', $directory->meta_title ?? '')) }}/60</small>
                    <small id="count-desc" class="text-muted">Description: {{ strlen(old('meta_description', $directory->meta_description ?? '')) }}/155</small>
                </div>
            </div>
        </div>

        {{-- SECTION 4: Categories & Tags --}}
        <div class="card-custom" style="animation-delay: 0.4s;">
            <div class="card-header-custom gradient-4">
                <span>🏷️</span> 4) Categories and Tags
            </div>
            <div class="card-body-custom">
                <div class="form-group-custom">
                    <label class="form-label-custom">Categories (select one or more)</label>
                    <div class="checkbox-grid">
                        @foreach($categories as $category)
                            <div class="checkbox-item">
                                <input type="checkbox"
                                       name="categories[]"
                                       value="{{ $category->id }}"
                                       id="cat-{{ $category->id }}"
                                       {{ collect(old('categories'))->contains($category->id) ? 'checked' : '' }}>
                                <label for="cat-{{ $category->id }}">{{ $category->name }}</label>
                            </div>
                        @endforeach
                    </div>
                    @error('categories') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    <small class="form-text-custom">✓ Select any - one or more</small>
                </div>

                <div class="form-group-custom">
                    <label class="form-label-custom">Tags (select one or more)</label>
                    <div class="checkbox-grid">
                        @foreach($tags as $tag)
                            <div class="checkbox-item">
                                <input type="checkbox"
                                       name="tags[]"
                                       value="{{ $tag->id }}"
                                       id="tag-{{ $tag->id }}"
                                       {{ collect(old('tags'))->contains($tag->id) ? 'checked' : '' }}>
                                <label for="tag-{{ $tag->id }}">{{ $tag->name }}</label>
                            </div>
                        @endforeach
                    </div>
                    @error('tags') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>

        {{-- Status Card (Second Last Row) --}}
        @if($author->user_role_id === 1)
            <div class="card-custom" style="animation-delay: 0.5s;">
                <div class="card-header-custom gradient-1">
                    <span>📝</span> 5) Status
                </div>
                <div class="card-body-custom">
                    <div class="checkbox-grid">
                        @foreach($statuses as $status)
                            <div class="checkbox-item">
                                <input type="radio"
                                       name="status"
                                       value="{{ $status }}"
                                       id="status-{{ $status }}"
                                       {{ old('status', 'draft') == $status ? 'checked' : '' }}>
                                <label for="status-{{ $status }}">
                                    {{ $status == 'draft' ? '📝 Draft' : ($status == 'published' ? '✅ Published' : '🗄️ Archived') }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @else
            <input type="hidden" name="status" value="draft">
        @endif

        {{-- Action Buttons (Last Row) --}}
        <div class="action-container">
            <small class="text-muted">💾 Save your work when you are satisfied</small>
            <div class="d-flex gap-3">
                <a href="{{ route('admin.posts.index') }}" class="btn-cancel">Cancel</a>
                <button type="submit" class="btn-submit">📤 Submit Post</button>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script src="{{ asset('tinymce/js/tinymce/tinymce.min.js') }}"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // TinyMCE Init
    try {
        tinymce.init({
            selector: 'textarea.tinymce',
            height: 500,
            menubar: true,
            plugins: 'preview paste importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media codesample table charmap anchor toc insertdatetime advlist lists wordcount textpattern help quickbars contextmenu',
            toolbar: 'undo redo | formatselect | fontsizeselect | fontselect | forecolor backcolor | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | outdent indent | numlist bullist | link image media | preview code',
            contextmenu: 'cut copy paste | link image inserttable | cell row column deletetable',
            license_key: 'gpl',
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

    // Image Preview
    const input = document.querySelector('#postImageInput');
    const preview = document.querySelector('#postImagePreview');
    const holder = document.querySelector('#postImagePlaceholder');
    const btnRm = document.querySelector('#postImageRemove');
    const meta = document.querySelector('#postImageMeta');

    function resetPreview() {
        preview.removeAttribute('src');
        preview.classList.add('d-none');
        holder.classList.remove('d-none');
        btnRm && btnRm.classList.add('d-none');
        meta && meta.classList.add('d-none');
    }

    function showPreview(file) {
        if (!file || !file.type.startsWith('image/')) { resetPreview(); return; }

        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            preview.classList.remove('d-none');
            holder.classList.add('d-none');
            btnRm && btnRm.classList.remove('d-none');
            if (meta) {
                const sizeKB = (file.size / 1024).toFixed(1);
                meta.textContent = `${file.name} • ${sizeKB} KB`;
                meta.classList.remove('d-none');
            }
        };
        reader.readAsDataURL(file);
    }

    input && input.addEventListener('change', function(e) {
        const file = e.target.files && e.target.files[0];
        if (!file) { resetPreview(); return; }
        showPreview(file);
    });

    btnRm && btnRm.addEventListener('click', resetPreview);
});

// SEO Preview Update
function updateSeoPreview() {
    const t = document.getElementById('meta_title')?.value || '';
    const d = document.getElementById('meta_description')?.value || '';
    const pvTitle = document.getElementById('pv-title');
    const pvDesc = document.getElementById('pv-desc');
    pvTitle && (pvTitle.innerText = t || 'Your SEO title will appear here');
    pvDesc && (pvDesc.innerText = d || 'Your meta description will appear here. Keep it brief and attractive.');
    const cT = document.getElementById('count-title');
    const cD = document.getElementById('count-desc');
    cT && (cT.innerText = `Title: ${t.length}/60`);
    cD && (cD.innerText = `Description: ${d.length}/155`);
}
</script>
@endpush
