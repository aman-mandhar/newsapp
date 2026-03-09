@extends('layouts.portal.view')

@push('styles')
<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    -webkit-tap-highlight-color: transparent;
}

:root {
    --primary: #000000;
    --secondary: #FF0000;
    --success: #000000;
    --danger: #FF0000;
    --dark: #000000;
    --light: #FAF2AC;
    --bg-main: #FAF2AC;
    --label-color: #FF0000;
    --text-color: #000000;
}

body {
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    background: #FAF2AC;
    min-height: 100vh;
    padding: 0;
    margin: 0;
    font-size: 16px;
    color: #000000;
}

/* Mobile Container */
.mobile-container {
    max-width: 100%;
    padding: 10px;
    padding-bottom: 100px;
    margin: 0;
    overflow: visible;
}

/* Mobile Header */
.mobile-header {
    background: white;
    border-radius: 15px;
    padding: 15px;
    margin-bottom: 15px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    position: sticky;
    top: 10px;
    z-index: 100;
}

.mobile-header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.mobile-header h1 {
    font-size: 1.25rem;
    font-weight: 700;
    color: #FF0000;
    margin: 0;
}

.btn-back-mobile {
    background: #000000;
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 20px;
    font-weight: 600;
    text-decoration: none;
    font-size: 0.875rem;
    display: flex;
    align-items: center;
    gap: 5px;
}

/* Alert Mobile */
.alert-mobile {
    background: white;
    border-left: 4px solid #FF0000;
    border-radius: 12px;
    padding: 15px;
    margin-bottom: 15px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.alert-mobile strong {
    color: #FF0000;
    display: block;
    margin-bottom: 8px;
}

/* Mobile Card */
.card-mobile {
    background: white;
    border-radius: 15px;
    margin-bottom: 15px;
    overflow: hidden;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    padding: 20px;
}

.card-header-mobile {
    padding: 15px;
    background: #000000;
    color: white;
    font-weight: 700;
    font-size: 1.1rem;
    display: flex;
    align-items: center;
    gap: 8px;
}

.card-header-mobile.gradient-1,
.card-header-mobile.gradient-2,
.card-header-mobile.gradient-3,
.card-header-mobile.gradient-4 {
    background: #000000;
    color: white;
.card-body-mobile {
    padding: 15px;
}

/* Form Mobile */
.form-group-mobile {
    margin-bottom: 20px;
}

.form-label-mobile {
    font-weight: 600;
    color: #FF0000;
    margin-bottom: 6px;
    display: block;
    font-size: 0.95rem;
}

.form-control-mobile {
    width: 100%;
    padding: 12px 15px;
    border: 2px solid #000000;
    border-radius: 10px;
    font-size: 16px;
    background: white;
    transition: all 0.3s;
    color: #000000;
}

.form-control-mobile:focus {
    outline: none;
    border-color: #FF0000;
    background: white;
    box-shadow: 0 0 0 3px rgba(255, 0, 0, 0.1);
}

textarea.form-control-mobile {
    min-height: 120px;
    resize: vertical;
    display: block !important;
}

textarea#contentEditor {
    min-height: 300px;
}

.form-text-mobile {
    color: #000000;
    font-size: 0.8rem;
    margin-top: 4px;
    display: block;
}

/* Image Upload Mobile */
.image-upload-mobile {
    border: 2px dashed #000000;
    border-radius: 12px;
    padding: 20px;
    text-align: center;
    background: white;
    cursor: pointer;
    transition: all 0.3s;
}

.image-upload-mobile:active {
    background: #F0F0F0;
    border-color: #FF0000;
}

.image-preview-mobile {
    margin-top: 15px;
    border-radius: 10px;
    overflow: hidden;
}

#postImagePreview {
    max-width: 100%;
    height: auto;
    border-radius: 10px;
}

.image-placeholder-mobile {
    font-size: 3rem;
    margin-bottom: 10px;
}

/* PDF Section Mobile */
.pdf-section-mobile {
    background: white;
    border: 2px solid #000000;
    padding: 15px;
    border-radius: 12px;
    margin-top: 15px;
}

.pdf-section-mobile h6 {
    color: #FF0000;
    font-weight: 700;
    margin-bottom: 12px;
    font-size: 1rem;
}

/* Select Mobile */
.form-select-mobile {
    width: 100%;
    padding: 10px;
    border: 2px solid #000000;
    border-radius: 10px;
    font-size: 16px;
    background: white;
    min-height: 120px;
    color: #000000;
}

.form-select-mobile:focus {
    outline: none;
    border-color: #FF0000;
    box-shadow: 0 0 0 3px rgba(255, 0, 0, 0.1);
}

/* Checkbox List Mobile */
.checkbox-list-mobile {
    max-height: 200px;
    overflow-y: auto;
    border: 2px solid #000000;
    border-radius: 10px;
    padding: 10px;
    background: white;
}

.checkbox-item-mobile {
    display: flex;
    align-items: center;
    padding: 10px;
    margin-bottom: 8px;
    background: #FAF2AC;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.2s;
    border: 1px solid #000000;
}

.checkbox-item-mobile:active {
    background: #F0E89D;
    transform: scale(0.98);
}

.checkbox-item-mobile input[type="checkbox"],
.checkbox-item-mobile input[type="radio"] {
    width: 20px;
    height: 20px;
    margin-right: 12px;
    cursor: pointer;
    accent-color: #000000;
}

.checkbox-item-mobile label {
    flex: 1;
    margin: 0;
    cursor: pointer;
    font-size: 0.95rem;
    color: #000000;
}

/* SEO Preview Mobile */
.serp-preview-mobile {
    background: white;
    border: 2px solid #000000;
    border-radius: 12px;
    padding: 15px;
    margin-top: 15px;
}

.serp__title-mobile {
    color: #FF0000;
    font-size: 1.1rem;
    font-weight: 600;
    margin: 8px 0;
}

.serp__desc-mobile {
    color: #000000;
    font-size: 0.875rem;
    line-height: 1.5;
}

/* Action Buttons Mobile */
.action-container-mobile {
    background: white;
    padding: 15px;
    border-radius: 15px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    position: sticky;
    bottom: 10px;
    margin-top: 20px;
    z-index: 10;
    overflow: visible !important;
}

.btn-mobile {
    width: 100%;
    min-height: 50px;
    padding: 14px 20px;
    border-radius: 12px;
    font-weight: 700;
    font-size: 1rem;
    border: none;
    cursor: pointer;
    transition: all 0.3s;
    display: block !important;
    text-align: center;
    text-decoration: none;
    line-height: 1.5;
    box-sizing: border-box;
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    overflow: visible !important;
    visibility: visible !important;
    opacity: 1 !important;
}

.btn-submit-mobile {
    background: #28a745 !important;
    color: #FFFFFF !important;
    box-shadow: 0 4px 12px rgba(40, 167, 69, 0.4);
    margin-bottom: 10px;
    width: 100%;
    border: none;
    outline: none;
    min-height: 50px;
}

.btn-submit-mobile:active {
    transform: scale(0.98);
    background: #218838 !important;
}

.btn-submit-mobile:hover {
    background: #218838 !important;
    color: white !important;
}

.btn-cancel-mobile {
    background: #dc3545 !important;
    color: #FFFFFF !important;
    border: none !important;
    width: 100%;
    display: block !important;
    text-decoration: none;
    box-sizing: border-box;
    min-height: 50px;
    box-shadow: 0 4px 12px rgba(220, 53, 69, 0.4);
}

.btn-cancel-mobile:active {
    background: #c82333 !important;
    color: #FFFFFF !important;
}

.btn-cancel-mobile:hover {
    background: #c82333 !important;
    text-decoration: none;
    color: #FFFFFF !important;
}

/* Required Mark */
.required {
    color: #EF4444;
    font-weight: bold;
}

/* Remove Button */
.btn-remove-mobile {
    background: #FF0000;
    color: white;
    border: none;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 600;
    margin-top: 10px;
}

/* Character Counter */
.char-counter {
    display: flex;
    justify-content: space-between;
    gap: 10px;
    margin-top: 10px;
    flex-wrap: wrap;
}

.char-counter small {
    background: white;
    padding: 4px 12px;
    border-radius: 8px;
    font-size: 0.75rem;
    color: #000000;
    border: 1px solid #000000;
}

/* Loader */
.loading-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.5);
    z-index: 9999;
    justify-content: center;
    align-items: center;
}

.loading-overlay.active {
    display: flex;
}

.spinner {
    width: 50px;
    height: 50px;
    border: 4px solid white;
    border-top: 4px solid #000000;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

/* Smooth Scroll */
html {
    scroll-behavior: smooth;
}

/* TinyMCE Mobile Adjustments */
.tox-tinymce {
    border-radius: 10px !important;
    border: 2px solid #000000 !important;
    margin-top: 5px;
    display: block !important;
    visibility: visible !important;
}

.tox .tox-toolbar,
.tox .tox-toolbar__overflow,
.tox .tox-toolbar__primary {
    background: #FAF2AC !important;
    padding: 4px !important;
}

.tox .tox-tbtn {
    margin: 2px 1px !important;
}

.tox .tox-edit-area__iframe {
    background: white !important;
}

.tox .tox-statusbar {
    background: #FAF2AC !important;
    border-top: 1px solid #000000 !important;
}

/* Ensure TinyMCE container is visible */
.tox-tinymce-aux {
    z-index: 9999 !important;
}

/* Make TinyMCE more touch-friendly on mobile */
@media (max-width: 768px) {
    .tox .tox-tbtn {
        height: 38px !important;
        width: 38px !important;
    }

    .tox .tox-toolbar__group {
        padding: 0 2px !important;
    }

    .tox-tinymce {
        max-width: 100% !important;
    }
}

/* Force button visibility - maximum specificity */
button.btn-submit-mobile,
a.btn-cancel-mobile {
    display: block !important;
    visibility: visible !important;
    opacity: 1 !important;
    height: auto !important;
    min-height: 50px !important;
    overflow: visible !important;
    position: relative !important;
    white-space: normal !important;
}

button.btn-submit-mobile span,
a.btn-cancel-mobile span {
    display: inline-block !important;
    visibility: visible !important;
    opacity: 1 !important;
}

.action-container-mobile {
    display: block !important;
    visibility: visible !important;
    position: relative !important;
    clear: both !important;
}
</style>
@endpush

@section('content')
<div class="mobile-container">
    {{-- Mobile Header --}}
    <div class="mobile-header">
        <div class="mobile-header-content">
            <h1>📝 New Post</h1>
            <a href="{{ route('admin.posts.index') }}" class="btn-back-mobile">✖ Close</a>
        </div>
    </div>

    {{-- Errors --}}
    @if ($errors->any())
        <div class="alert-mobile">
            <strong>⚠️ Errors:</strong>
            <ul style="margin: 8px 0 0 20px;">
                @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
            </ul>
        </div>
    @endif

    @if($author->user_role_id === 1)
        <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data" id="postForm">
    @else
        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" id="postForm">
    @endif
        @csrf

        {{-- Content Section --}}
        <div class="card-mobile">
            <div class="card-header-mobile gradient-1">
                ✍️ Content
            </div>
            <div class="card-body-mobile">
                <div class="form-group-mobile">
                    <label class="form-label-mobile">Title <span class="required">*</span></label>
                    <input type="text" name="title" class="form-control-mobile @error('title') is-invalid @enderror"
                           value="{{ old('title') }}" required
                           placeholder="Write an attractive title...">
                    @error('title') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="form-group-mobile">
                    <label class="form-label-mobile">Content / Description</label>
                    <textarea id="contentEditor" name="content" class="form-control-mobile @error('content') is-invalid @enderror"
                              rows="8"
                              placeholder="Write your content here...">{{ old('content') }}</textarea>
                    @error('content') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    <small class="form-text-mobile">💡 Use the rich text editor to format your content</small>
                </div>
            </div>
        </div>

        {{-- Media Section --}}
        <div class="card-mobile">
            <div class="card-header-mobile gradient-2">
                🖼️ Media
            </div>
            <div class="card-body-mobile">
                <label class="form-label-mobile">Choose Photo</label>
                <div class="image-upload-mobile" onclick="document.getElementById('postImageInput').click()">
                    <div class="image-placeholder-mobile">📷</div>
                    <div style="font-weight: 600;">Tap to choose photo</div>
                    <small class="form-text-mobile">JPG, PNG or WebP (maximum 3MB)</small>
                </div>
                <input type="file"
                       id="postImageInput"
                       name="image"
                       class="d-none @error('image') is-invalid @enderror"
                       accept="image/*">
                @error('image') <div class="text-danger small mt-1">{{ $message }}</div> @enderror

                <div class="image-preview-mobile d-none" id="imagePreviewContainer">
                    <img id="postImagePreview" alt="Preview">
                    <button type="button" id="postImageRemove" class="btn-remove-mobile">Remove</button>
                    <div class="text-muted small mt-2" id="postImageMeta"></div>
                </div>

                {{-- PDF Section --}}
                <div class="pdf-section-mobile">
                    <h6>📄 PDF (Optional)</h6>
                    <div class="form-group-mobile">
                        <input type="url"
                               id="pdfUrl"
                               name="pdf_url"
                               class="form-control-mobile @error('pdf_url') is-invalid @enderror"
                               value="{{ old('pdf_url') }}"
                               placeholder="Paste PDF link">
                        @error('pdf_url') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group-mobile">
                        <input type="text"
                               name="pdf_title"
                               class="form-control-mobile @error('pdf_title') is-invalid @enderror"
                               value="{{ old('pdf_title') }}"
                               placeholder="PDF name (optional)">
                        @error('pdf_title') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- SEO Section --}}
        <div class="card-mobile">
            <div class="card-header-mobile gradient-3">
                🔍 SEO
            </div>
            <div class="card-body-mobile">
                <div class="form-group-mobile">
                    <label class="form-label-mobile">Meta Title</label>
                    <input type="text" id="meta_title" name="meta_title" class="form-control-mobile"
                           value="{{ old('meta_title') }}"
                           maxlength="60"
                           oninput="updateSeoPreview()"
                           placeholder="SEO title">
                </div>

                <div class="form-group-mobile">
                    <label class="form-label-mobile">Meta Description</label>
                    <textarea id="meta_description" name="meta_description" rows="3" class="form-control-mobile"
                              maxlength="155"
                              oninput="updateSeoPreview()"
                              placeholder="Brief description...">{{ old('meta_description') }}</textarea>
                </div>

                <div class="form-group-mobile">
                    <label class="form-label-mobile">Keywords</label>
                    <input type="text" name="meta_keywords" class="form-control-mobile"
                           value="{{ old('meta_keywords') }}"
                           placeholder="keyword1, keyword2">
                </div>

                <div class="serp-preview-mobile">
                    <div class="text-muted small mb-2">📱 Preview:</div>
                    <div id="pv-title" class="serp__title-mobile">
                        Your title will appear here
                    </div>
                    <div id="pv-desc" class="serp__desc-mobile">
                        Your description will appear here
                    </div>
                </div>

                <div class="char-counter">
                    <small id="count-title" class="text-muted">Title: 0/60</small>
                    <small id="count-desc" class="text-muted">Description: 0/155</small>
                </div>
            </div>
        </div>

        {{-- Categories & Tags --}}
        <div class="card-mobile">
            <div class="card-header-mobile gradient-4">
                🏷️ Categories & Tags
            </div>
            <div class="card-body-mobile">
                <div class="form-group-mobile">
                    <label class="form-label-mobile">Categories (select one or more)</label>
                    <div class="checkbox-grid-mobile">
                        @foreach($categories as $category)
                            <div class="checkbox-item-mobile">
                                <input type="checkbox"
                                       name="categories[]"
                                       value="{{ $category->id }}"
                                       id="cat-mobile-{{ $category->id }}"
                                       {{ collect(old('categories'))->contains($category->id) ? 'checked' : '' }}>
                                <label for="cat-mobile-{{ $category->id }}">{{ $category->name }}</label>
                            </div>
                        @endforeach
                    </div>
                    <small class="form-text-mobile">✓ Select any as needed</small>
                </div>

                <div class="form-group-mobile">
                    <label class="form-label-mobile">Tags (select one or more)</label>
                    <div class="checkbox-list-mobile">
                        @foreach($tags as $tag)
                            <div class="checkbox-item-mobile">
                                <input type="checkbox"
                                       name="tags[]"
                                       value="{{ $tag->id }}"
                                       id="tag-mobile-{{ $tag->id }}"
                                       {{ collect(old('tags'))->contains($tag->id) ? 'checked' : '' }}>
                                <label for="tag-mobile-{{ $tag->id }}">{{ $tag->name }}</label>
                            </div>
                        @endforeach
                    </div>
                    <small class="form-text-mobile">✓ Select any as needed</small>
                </div>
            </div>
        </div>

        {{-- Status Card (Second Last Row) --}}
        @if($author->user_role_id === 1)
            <div class="card-mobile">
                <div class="card-header-mobile gradient-1">
                    📝 Status
                </div>
                <div class="card-body-mobile">
                    <div class="form-group-mobile">
                        <div class="checkbox-list-mobile">
                            @foreach($statuses as $status)
                                <div class="checkbox-item-mobile">
                                    <input type="radio"
                                           name="status"
                                           value="{{ $status }}"
                                           id="status-mobile-{{ $status }}"
                                           {{ old('status', 'published') == $status ? 'checked' : '' }}>
                                    <label for="status-mobile-{{ $status }}">
                                        {{ $status == 'draft' ? '📝 Draft' : ($status == 'published' ? '✅ Publish' : '🗄️ Archived') }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @else
            <input type="hidden" name="status" value="draft">
        @endif

        {{-- Action Buttons (Last Row) --}}
        <div class="action-container-mobile">
            <div class="row">
                <div class="col-6">
                    <button type="submit" class="btn-mobile btn-submit-mobile" style="display: block !important; visibility: visible !important; background: #28a745 !important; color: #FFFFFF !important;">
                        <span style="display: inline-block; color: #FFFFFF;">✅ Create News</span>
                    </button>
                </div>
                <div class="col-6">
                    <a href="{{ route('admin.posts.index') }}" class="btn-mobile btn-cancel-mobile" style="display: block !important; visibility: visible !important; background: #dc3545 !important; color: #FFFFFF !important;">
                    <span style="display: inline-block; color: #FFFFFF;">❌ Cancel</span>
                </div>
            </div>
            </a>
        </div>
    </form>
</div>

{{-- Loading Overlay --}}
<div class="loading-overlay" id="loadingOverlay">
    <div class="spinner"></div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('tinymce/js/tinymce/tinymce.min.js') }}"></script>

<script>
// Wait for everything to load
window.addEventListener('load', function() {
    // Small delay to ensure TinyMCE is fully loaded
    setTimeout(function() {
        initTinyMCE();
    }, 100);
});

function initTinyMCE() {
    // Check if TinyMCE is loaded
    if (typeof tinymce === 'undefined') {
        console.error('TinyMCE is not loaded! Check the script path.');
        document.getElementById('contentEditor').style.display = 'block';
        return;
    }

    // Check if element exists
    const editor = document.getElementById('contentEditor');
    if (!editor) {
        console.error('Content editor element not found!');
        return;
    }

    console.log('Initializing TinyMCE...');

    // TinyMCE Init - Enhanced Mobile Optimized
    try {
        tinymce.init({
            selector: '#contentEditor',
            height: 450,

            // Universal Configuration (works on both mobile and desktop)
            menubar: false,
            plugins: [
                'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                'insertdatetime', 'media', 'table', 'help', 'wordcount'
            ],

            toolbar: 'undo redo | blocks | ' +
                'bold italic underline strikethrough | forecolor backcolor | ' +
                'alignleft aligncenter alignright alignjustify | ' +
                'bullist numlist outdent indent | ' +
                'link image media | ' +
                'removeformat | help',

            // Make toolbar responsive - adapts to screen size
            toolbar_mode: 'sliding',

            // Content styling
            content_style: `
                body {
                    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
                    font-size: 16px;
                    line-height: 1.6;
                    color: #000000;
                    padding: 15px;
                }
                p { margin: 0 0 10px 0; }
                img { max-width: 100%; height: auto; }
            `,

            // Font options
            font_family_formats: 'Arial=arial,helvetica,sans-serif; ' +
                'Courier New=courier new,courier,monospace; ' +
                'Georgia=georgia,palatino; ' +
                'Tahoma=tahoma,arial,helvetica,sans-serif; ' +
                'Times New Roman=times new roman,times; ' +
                'Verdana=verdana,geneva',

            font_size_formats: '8pt 10pt 12pt 14pt 16pt 18pt 24pt 36pt 48pt',

            // Block formats
            block_formats: 'Paragraph=p; Heading 1=h1; Heading 2=h2; Heading 3=h3; Heading 4=h4; Heading 5=h5; Heading 6=h6; Preformatted=pre',

            // Image settings
            image_advtab: true,
            image_caption: true,
            image_title: true,

            // Link settings
            link_assume_external_targets: true,
            link_title: false,
            target_list: [
                {title: 'New window', value: '_blank'},
                {title: 'Same window', value: '_self'}
            ],

            // Upload settings
            license_key: 'gpl',
            relative_urls: false,
            remove_script_host: false,
            images_upload_url: '{{ route('tinymce.upload') }}',
            automatic_uploads: true,
            file_picker_types: 'image',

            // Image upload handler
            images_upload_handler: function (blobInfo, success, failure) {
                const xhr = new XMLHttpRequest();
                xhr.withCredentials = false;
                xhr.open('POST', '{{ route('tinymce.upload') }}');
                xhr.setRequestHeader('X-CSRF-Token', '{{ csrf_token() }}');

                xhr.onload = function () {
                    if (xhr.status !== 200) {
                        failure('HTTP Error: ' + xhr.status);
                        return;
                    }

                    let json = {};
                    try {
                        json = JSON.parse(xhr.responseText);
                    } catch (e) {
                        failure('Invalid response format');
                        return;
                    }

                    if (!json || typeof json.location !== 'string') {
                        failure('Invalid JSON: ' + xhr.responseText);
                        return;
                    }

                    success(json.location);
                };

                xhr.onerror = function () {
                    failure('Image upload failed. Please check your connection.');
                };

                const formData = new FormData();
                formData.append('file', blobInfo.blob(), blobInfo.filename());
                xhr.send(formData);
            },

            // Paste settings
            paste_as_text: false,
            paste_data_images: true,

            // Additional settings for better mobile experience
            branding: false,
            promotion: false,
            statusbar: true,
            resize: true,

            // Auto-save
            autosave_interval: '30s',
            autosave_prefix: 'tinymce-autosave-{path}{query}-{id}-',
            autosave_restore_when_empty: false,
            autosave_retention: '2m',

            // Setup callback
            setup: function(editor) {
                editor.on('init', function() {
                    console.log('✅ TinyMCE editor initialized successfully!');
                    // Ensure the editor is visible
                    editor.getContainer().style.display = 'block';
                });

                editor.on('change', function() {
                    editor.save();
                });
            }
        });
    } catch (e) {
        console.error('[TinyMCE init error]', e);
        alert('Editor failed to load: ' + e.message + '\n\nPlease refresh the page.');
        // Show the textarea as fallback
        document.getElementById('contentEditor').style.display = 'block';
    }
}

// Initialize other features on DOM ready
document.addEventListener('DOMContentLoaded', function() {
    // Image Preview
    const input = document.getElementById('postImageInput');
    const preview = document.getElementById('postImagePreview');
    const container = document.getElementById('imagePreviewContainer');
    const btnRm = document.getElementById('postImageRemove');
    const meta = document.getElementById('postImageMeta');

    function showPreview(file) {
        if (!file || !file.type.startsWith('image/')) return;

        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            container.classList.remove('d-none');
            if (meta) {
                const sizeKB = (file.size / 1024).toFixed(1);
                meta.textContent = `${file.name} • ${sizeKB} KB`;
            }
        };
        reader.readAsDataURL(file);
    }

    function resetPreview() {
        preview.src = '';
        container.classList.add('d-none');
        input.value = '';
    }

    input && input.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) showPreview(file);
    });

    btnRm && btnRm.addEventListener('click', resetPreview);

    // Form Submit
    const form = document.getElementById('postForm');
    const loadingOverlay = document.getElementById('loadingOverlay');

    form && form.addEventListener('submit', function() {
        // Sync TinyMCE content before submit
        if (typeof tinymce !== 'undefined' && tinymce.get('contentEditor')) {
            tinymce.get('contentEditor').save();
        }
        loadingOverlay.classList.add('active');
    });
});

// SEO Preview
function updateSeoPreview() {
    const t = document.getElementById('meta_title')?.value || '';
    const d = document.getElementById('meta_description')?.value || '';
    const pvTitle = document.getElementById('pv-title');
    const pvDesc = document.getElementById('pv-desc');
    pvTitle && (pvTitle.innerText = t || 'Your title will appear here');
    pvDesc && (pvDesc.innerText = d || 'Your description will appear here');
    const cT = document.getElementById('count-title');
    const cD = document.getElementById('count-desc');
    cT && (cT.innerText = `Title: ${t.length}/60`);
    cD && (cD.innerText = `Description: ${d.length}/155`);
}
</script>
@endpush
