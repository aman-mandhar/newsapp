{{-- PDF Embed Component - Usage: @include('components.pdf-embed', ['pdfUrl' => 'https://drive.google.com/...']) --}}
@props(['pdfUrl', 'title' => 'View PDF Document', 'height' => '600px'])

@if($pdfUrl)
<div class="pdf-embed-container my-4" style="border: 1px solid #e5e7eb; border-radius: 8px; overflow: hidden;">
    @if($title)
    <div class="pdf-header" style="background: #f9fafb; padding: 12px 16px; border-bottom: 1px solid #e5e7eb;">
        <h4 style="margin: 0; font-size: 1rem; font-weight: 600; color: #1f2937;">
            <i class="far fa-file-pdf text-danger"></i> {{ $title }}
        </h4>
    </div>
    @endif

    <div class="pdf-viewer" style="position: relative; background: #fff;">
        @php
            // Convert Google Drive URL to embed format
            $embedUrl = $pdfUrl;
            if (str_contains($pdfUrl, 'drive.google.com')) {
                // Extract file ID from various Google Drive URL formats
                if (preg_match('/\/file\/d\/([a-zA-Z0-9_-]+)/', $pdfUrl, $matches)) {
                    $fileId = $matches[1];
                    $embedUrl = "https://drive.google.com/file/d/{$fileId}/preview";
                } elseif (preg_match('/id=([a-zA-Z0-9_-]+)/', $pdfUrl, $matches)) {
                    $fileId = $matches[1];
                    $embedUrl = "https://drive.google.com/file/d/{$fileId}/preview";
                }
            }
        @endphp

        <iframe
            src="{{ $embedUrl }}"
            style="width: 100%; height: {{ $height }}; border: none;"
            allow="autoplay"
            loading="lazy"
        ></iframe>
    </div>

    <div class="pdf-footer" style="background: #f9fafb; padding: 8px 16px; border-top: 1px solid #e5e7eb; text-align: right;">
        <a href="{{ $pdfUrl }}" target="_blank" class="btn btn-sm btn-outline-primary" style="text-decoration: none;">
            <i class="fas fa-external-link-alt"></i> Open in New Tab
        </a>
    </div>
</div>
@endif
