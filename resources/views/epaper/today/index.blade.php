@extends('layouts.blank')

{{-- SEO Tags --}}
@section('title', 'Today\'s E-Paper - Lokbani | Daily Punjabi Newspaper')
@section('description', 'Read today\'s Lokbani E-Paper online. Lokbani is a Daily Punjabi Newspaper published at Jalandhar, Punjab. Get latest news, updates and information.')
@section('keywords', 'lokbani epaper, punjabi newspaper, daily newspaper, jalandhar newspaper, punjab news, lokbani today, epaper online')
@section('og_title', 'Today\'s E-Paper - Lokbani')
@section('og_description', 'Read today\'s Lokbani E-Paper online. Daily Punjabi Newspaper published at Jalandhar, Punjab.')
@section('og_image', asset('images/icon.png'))
@section('og_url', url()->current())
@section('og_type', 'article')

@push('styles')
<style>
body {
    margin: 0;
    padding: 0;
    background: #2c3e50;
    overflow: hidden;
}

.epaper-container {
    width: 100vw;
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
}

.pdf-viewer {
    width: 100%;
    height: 100%;
    border: none;
}

.pdf-embed {
    width: 100%;
    height: 100%;
}

.no-pdf-message {
    text-align: center;
    color: white;
    padding: 40px;
}

.no-pdf-message h1 {
    font-size: 2rem;
    margin-bottom: 20px;
}

.no-pdf-message p {
    font-size: 1.2rem;
    opacity: 0.8;
}

.pdf-controls {
    position: fixed;
    top: 10px;
    right: 10px;
    z-index: 1000;
    background: rgba(0, 0, 0, 0.7);
    padding: 10px;
    border-radius: 8px;
    display: flex;
    gap: 10px;
}

.pdf-controls a,
.pdf-controls button {
    background: white;
    color: #2c3e50;
    border: none;
    padding: 8px 16px;
    border-radius: 5px;
    text-decoration: none;
    font-weight: 600;
    cursor: pointer;
    font-size: 14px;
    transition: all 0.3s ease;
}

.pdf-controls a:hover,
.pdf-controls button:hover {
    background: #FF0000;
    color: white;
    transform: translateY(-2px);
}

.pdf-info {
    position: fixed;
    bottom: 10px;
    left: 10px;
    background: rgba(0, 0, 0, 0.7);
    color: white;
    padding: 10px 20px;
    border-radius: 8px;
    font-size: 14px;
    z-index: 1000;
}

@media (max-width: 768px) {
    .pdf-controls {
        top: 5px;
        right: 5px;
        padding: 5px;
        flex-direction: column;
    }

    .pdf-controls a,
    .pdf-controls button {
        padding: 6px 12px;
        font-size: 12px;
    }

    .pdf-info {
        bottom: 5px;
        left: 5px;
        padding: 8px 12px;
        font-size: 12px;
    }
}
</style>
@endpush

@section('content')
<div class="epaper-container">
    @if($post && $post->pdf_url)
        @php
            // Determine if URL is Google Drive or local storage
            $isGoogleDrive = str_contains($post->pdf_url, 'drive.google.com');

            if ($isGoogleDrive) {
                // Convert Google Drive URL to embed format
                $pdfUrl = $post->pdf_url;
                if (preg_match('/\/file\/d\/([a-zA-Z0-9_-]+)/', $post->pdf_url, $matches)) {
                    $fileId = $matches[1];
                    $embedUrl = "https://drive.google.com/file/d/{$fileId}/preview";
                } elseif (preg_match('/id=([a-zA-Z0-9_-]+)/', $post->pdf_url, $matches)) {
                    $fileId = $matches[1];
                    $embedUrl = "https://drive.google.com/file/d/{$fileId}/preview";
                } else {
                    $embedUrl = $post->pdf_url;
                }
            } else {
                // Local storage path
                $pdfUrl = asset('storage/' . $post->pdf_url);
                $embedUrl = $pdfUrl . '#toolbar=1&navpanes=0&scrollbar=1';
            }
        @endphp

        {{-- PDF Controls --}}
        <div class="pdf-controls">
            <a href="{{ $pdfUrl }}" target="_blank" title="Open in new tab">
                <i class="bi bi-box-arrow-up-right"></i> Open
            </a>
            @if(!$isGoogleDrive)
                <a href="{{ $pdfUrl }}" download title="Download PDF">
                    <i class="bi bi-download"></i> Download
                </a>
            @endif
            <button onclick="toggleFullscreen()" title="Toggle fullscreen">
                <i class="bi bi-fullscreen"></i> Fullscreen
            </button>
        </div>

        {{-- PDF Info --}}
        <div class="pdf-info">
            <strong>{{ $post->pdf_title ?? $post->title }}</strong>
            <br>
            <small>{{ $post->published_at ? $post->published_at->format('d M Y') : 'Today' }}</small>
        </div>

        {{-- PDF Viewer --}}
        <iframe
            src="{{ $embedUrl }}"
            class="pdf-viewer"
            title="{{ $post->pdf_title ?? 'E-Paper' }}"
            loading="lazy">
            <p>Your browser does not support PDFs.
                <a href="{{ $pdfUrl }}" target="_blank">Download the PDF</a>
            </p>
        </iframe>
    @else
        <div class="no-pdf-message">
            <h1><i class="bi bi-file-pdf"></i> No E-Paper Available</h1>
            <p>There is no e-paper published for today.</p>
            <p class="mt-4">
                <a href="{{ url('/') }}" class="btn btn-light btn-lg">
                    <i class="bi bi-house"></i> Go to Home
                </a>
            </p>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
function toggleFullscreen() {
    if (!document.fullscreenElement) {
        document.documentElement.requestFullscreen().catch(err => {
            console.log('Error attempting to enable fullscreen:', err);
        });
    } else {
        if (document.exitFullscreen) {
            document.exitFullscreen();
        }
    }
}

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // F key for fullscreen
    if (e.key === 'f' || e.key === 'F') {
        e.preventDefault();
        toggleFullscreen();
    }

    // Escape key to exit fullscreen
    if (e.key === 'Escape' && document.fullscreenElement) {
        document.exitFullscreen();
    }
});

// Update fullscreen button icon
document.addEventListener('fullscreenchange', function() {
    const btn = document.querySelector('.pdf-controls button');
    const icon = btn.querySelector('i');
    if (document.fullscreenElement) {
        icon.classList.remove('bi-fullscreen');
        icon.classList.add('bi-fullscreen-exit');
    } else {
        icon.classList.remove('bi-fullscreen-exit');
        icon.classList.add('bi-fullscreen');
    }
});
</script>
@endpush
