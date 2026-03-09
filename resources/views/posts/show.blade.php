@extends('layouts.portal.view')

{{-- SEO & OG Tags --}}
@section('title', $post->meta_title ?? $post->title)
@section('description', $post->meta_description ?? Str::limit(strip_tags($post->content), 150))
@section('keywords', $post->meta_keywords)
@section('og_title', $post->title)
@section('og_description', $post->meta_description ?? Str::limit(strip_tags($post->content), 150))
@section('og_image', $post->image_path ? asset('storage/' . $post->image_path) : asset('images/logo.png'))
@section('og_url', url()->current())

@push('styles')
<link href="{{ asset('css/tinymce-content.css') }}" rel="stylesheet">

{{-- UI-focused CSS for share buttons & author (move to compiled CSS later) --}}
<style>
:root{
  --primary-color: #000000;
  --secondary-color: #FF0000;
  --bg-main: #FAF2AC;
  --text-color: #000000;
  --card-bg: #FFFFFF;
  --border-color: #000000;
  --brand-whatsapp: #25D366;
  --brand-facebook: #1877F2;
  --brand-email: #EA4335;
  --brand-copy: #6B7280;
  --btn-radius: 10px;
  --btn-padding: 0.45rem 0.9rem;
}

/* Main Layout */
body {
  background: #FAF2AC !important;
  color: #000000 !important;
}

.blog_area {
  background: #FAF2AC !important;
  padding: 40px 0;
  margin-top: 30px;
  position: relative;
  z-index: 1;
}

/* Main Column Sticky */
.posts-list {
  position: sticky;
  top: 20px;
  align-self: flex-start;
}

/* Post Container */
.single-post {
  background: white;
  border: 2px solid #000000;
  border-radius: 15px;
  padding: 30px;
  box-shadow: 0 4px 16px rgba(0,0,0,0.12);
}

.feature-img img {
  border: 2px solid #000000;
  border-radius: 12px;
  width: 100%;
  object-fit: cover;
}

/* Post Title */
.blog_details h2 {
  color: #FF0000 !important;
  font-weight: 700;
  margin-bottom: 20px;
  padding-bottom: 15px;
  border-bottom: 3px solid #000000;
}

/* Breadcrumbs */
.breadcrumb {
  background: #FAF2AC;
  border: 2px solid #000000;
  border-radius: 10px;
  padding: 12px 20px;
}

.breadcrumb-item a {
  color: #000000;
  font-weight: 600;
  text-decoration: none;
}

.breadcrumb-item a:hover {
  color: #FF0000;
}

.breadcrumb-item.active {
  color: #FF0000;
  font-weight: 600;
}

.breadcrumb-item + .breadcrumb-item::before {
  color: #000000;
}

/* Meta Info */
.text-muted {
  color: #000000 !important;
  font-weight: 500;
}

.text-muted i {
  color: #FF0000;
}

/* Post Content */
.post-content {
  color: #000000;
  line-height: 1.8;
  font-size: 1.05rem;
}

.post-content h1,
.post-content h2,
.post-content h3,
.post-content h4,
.post-content h5,
.post-content h6 {
  color: #000000 !important;
  font-weight: 700;
  margin-top: 25px;
  margin-bottom: 15px;
}

.post-content p {
  margin-bottom: 15px;
}

.post-content a {
  color: #FF0000;
  font-weight: 600;
}

.post-content a:hover {
  color: #000000;
  text-decoration: underline;
}

.post-content img {
  max-width: 100%;
  height: auto;
  display: block;
  border: 2px solid #000000;
  border-radius: 10px;
  margin: 20px 0;
}

.post-content table {
  width: 100%;
  border-collapse: collapse;
  border: 2px solid #000000;
  margin: 20px 0;
}

.post-content table th,
.post-content table td {
  border: 1px solid #000000;
  padding: 10px;
}

.post-content table th {
  background: #000000;
  color: white;
  font-weight: 700;
}

/* Badges */
.badge {
  padding: 6px 14px;
  border-radius: 15px;
  font-weight: 600;
  font-size: 0.85rem;
  margin-right: 5px;
  margin-bottom: 5px;
  display: inline-block;
}

.badge.bg-dark {
  background: #FF0000 !important;
  color: white !important;
}

.badge.bg-secondary {
  background: #000000 !important;
  color: white !important;
}

/* Author Card */
.author-card {
  background: white;
  border: 2px solid #000000 !important;
  border-radius: 12px;
  padding: 20px;
  margin: 30px 0;
  box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}

.author-card strong {
  color: #FF0000;
  font-size: 1.1rem;
}

.author-card .text-muted {
  color: #000000 !important;
}

/* Share Section */
.card {
  background: white;
  border: 2px solid #000000 !important;
  border-radius: 12px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}

.card-title {
  color: #FF0000 !important;
  font-weight: 700;
  font-size: 1.3rem;
}

.share-buttons {
  gap: 0.5rem;
}

.btn-share {
  display: inline-flex;
  align-items: center;
  gap: .6rem;
  padding: var(--btn-padding);
  border-radius: var(--btn-radius);
  border: 2px solid #000000;
  color: #fff;
  font-weight: 600;
  text-decoration: none;
  transition: transform .08s ease, box-shadow .12s ease, opacity .12s ease;
  box-shadow: 0 4px 10px rgba(0,0,0,0.15);
  min-height: 40px;
  line-height: 1;
}

.btn-share i {
  font-size: 1.05rem;
  display: inline-flex;
  align-items: center;
  justify-content: center;
}

.btn-share__text {
  font-size: 0.92rem;
}

/* Brand variants */
.btn-share--whatsapp {
  background: var(--brand-whatsapp);
}

.btn-share--facebook {
  background: var(--brand-facebook);
}

.btn-share--email {
  background: var(--brand-email);
}

.btn-share--copy {
  background: var(--brand-copy);
}

/* Hover / active / focus */
.btn-share:hover {
  transform: translateY(-2px);
  box-shadow: 0 10px 30px rgba(0,0,0,0.2);
  opacity: 0.98;
  text-decoration: none;
}

.btn-share:active {
  transform: translateY(0);
  box-shadow: 0 6px 16px rgba(0,0,0,0.15);
}

.btn-share:focus {
  outline: 3px solid rgba(255, 0, 0, 0.3);
  outline-offset: 3px;
}

.btn-share i {
  color: #fff;
}

.top-a-slider {
    position: relative;
    width: 100%;
    max-width: 1200px;
    margin: 30px auto;
    overflow: hidden;
    border: 2px solid #000000;
    border-radius: 12px;
    box-shadow: 0 4px 16px rgba(0,0,0,0.12);
    background: white;
}

/* Maintain 1923:560 aspect ratio */
.top-a-slider::before {
    content: '';
    display: block;
    padding-top: 29.12%; /* 560/1923 * 100 = 29.12% */
}

.top-a-slide {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    transition: opacity 1s ease-in-out;
    display: none;
}

.top-a-slide.active {
    opacity: 1;
    display: block;
}

/* Top-Side Slider (Sidebar) - Desktop Only */
.top-side-slider {
    position: relative;
    width: 100%;
    overflow: hidden;
    border: 2px solid #000000;
    border-radius: 12px;
    box-shadow: 0 4px 16px rgba(0,0,0,0.12);
    background: white;
    margin-bottom: 20px;
}



.top-side-slider::before {
    content: '';
    display: block;
    padding-top: 100%; /* Square ratio for sidebar */
}

.top-side-slide {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    transition: opacity 1s ease-in-out;
    display: none;
}

.top-side-slide.active {
    opacity: 1;
    display: block;
}

/* Main Slider with dots */
.slider-container {
    position: relative;
    width: 100%;
    overflow: hidden;
}

.slide-item {
    display: none;
    opacity: 0;
    transition: opacity 0.5s ease-in-out;
}

.slide-item.active {
    display: block;
    opacity: 1;
}

.slider-dots {
    text-align: center;
    padding: 15px 0;
    margin: 0;
}

.slider-dot {
    display: inline-block;
    width: 12px;
    height: 12px;
    margin: 0 6px;
    border-radius: 50%;
    background: #ccc;
    border: 2px solid #000;
    cursor: pointer;
    transition: all 0.3s ease;
}

.slider-dot.active,
.slider-dot:hover {
    background: #FF0000;
    transform: scale(1.2);
}

/* Responsive: wrap comfortably on small screens */
@media (max-width: 991px) {
  .posts-list {
    position: static;
  }

  .blog_right_sidebar {
    position: static !important;
    margin-top: 40px;
  }

  .blog_area {
    margin-top: 20px;
  }
}

@media (max-width: 768px) {
  .top-a-slider {
    margin: 20px auto;
    border-radius: 8px;
  }

  .single-post {
    padding: 20px;
    border-radius: 10px;
  }

  .blog_details h2 {
    font-size: 1.5rem;
  }

  .post-content {
    font-size: 1rem;
  }

  .feature-img img {
    border-radius: 8px;
  }
}

@media (max-width: 576px) {
  .btn-share__text {
    display: inline-block;
  }

  .share-buttons {
    gap: .5rem;
  }

  .btn-share {
    padding: .45rem .75rem;
    font-size: .88rem;
    min-height: 36px;
    border-radius: 8px;
  }

  .single-post {
    padding: 15px;
  }

  .top-a-slider {
    margin: 15px auto;
  }

  .top-a-slider::before {
    padding-top: 50%; /* More square on mobile */
  }

  .blog_details h2 {
    font-size: 1.3rem;
  }

  .breadcrumb {
    padding: 8px 15px;
    font-size: 0.85rem;
  }

  .author-card {
    padding: 15px;
  }

  .card-title {
    font-size: 1.1rem !important;
  }

  .slider-dot {
    width: 10px;
    height: 10px;
    margin: 0 4px;
  }

  .blog_area {
    margin-top: 15px;
  }

  .logo-slider img {
    height: auto !important;
    max-height: 100px;
  }
}

/* Toast */
.share-toast {
  position: fixed;
  right: 20px;
  bottom: 26px;
  background: #000000;
  color: #FAF2AC;
  padding: 12px 18px;
  border-radius: 10px;
  border: 2px solid #FF0000;
  box-shadow: 0 8px 22px rgba(0,0,0,0.3);
  z-index: 1200;
  font-size: 0.925rem;
  font-weight: 600;
  display: inline-block;
  transform: translateY(12px);
  opacity: 0;
  transition: opacity .18s ease, transform .18s ease;
}

.share-toast.show {
  opacity: 1;
  transform: translateY(0);
}

/* Sidebar */
.blog_right_sidebar {
  position: sticky;
  top: 20px;
  align-self: flex-start;
}

.blog_right_sidebar .card {
  background: white;
  border: 2px solid #000000 !important;
  border-radius: 12px;
  margin-bottom: 20px;
}

.blog_right_sidebar h4,
.blog_right_sidebar h5 {
  color: #FF0000 !important;
  font-weight: 700;
  border-bottom: 2px solid #000000;
  padding-bottom: 10px;
  margin-bottom: 15px;
}

/* top-b-slider */
.top-b-slider {
  display: inline-block;
  margin-bottom: 30px;
}

.top-b-slider img {
  width: 1200px;
  height: auto;
  transition: transform 0.3s ease;
  margin-bottom: 0;
}

@media
(max-width: 1280px) {
  .top-b-slider img {
    width: 100%;
    height: auto;
  }
}
.top-b-slider:hover img {
  transform: scale(1.05);
}
</style>
@endpush

@section('content')
<div class="container">
    <div class="top-a-slider">
        <img src="{{ asset('img/ads/top-a/1.png') }}" alt="Advertisement" class="top-a-slide active">
        <img src="{{ asset('img/ads/top-a/2.png') }}" alt="Advertisement" class="top-a-slide">
    </div>
</div>
<!--================Blog Area =================-->
<section class="blog_area single-post-area section-padding">
  <div class="container">
    <div class="row">
      <!-- Main column -->
      <div class="col-lg-8 posts-list">
        <div class="single-post">
          <div class="feature-img">
            {{-- Post Image --}}
            @if($post->image_path)
              <img src="{{ asset('storage/' . $post->image_path) }}"
                   alt="{{ $post->title }}"
                   loading="lazy"
                   class="img-fluid mb-4 rounded">
            @endif
          </div>

          <p class="text-muted mb-4">
            <small>
              <i class="bi bi-calendar"></i> {{ $post->created_at->format('d M Y') }} |
              <i class="bi bi-eye"></i> {{ $post->views_count }} Views
            </small>
          </p>

          <div class="blog_details">
            <h2>{{ $post->title }}</h2>

            {{-- Breadcrumbs --}}
            <nav aria-label="breadcrumb" class="mb-4">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('posts.all') }}">All Posts</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($post->title, 50) }}</li>
              </ol>
            </nav>
          </div>

          {{-- Post Content --}}
          <div class="post-content mb-4">
            {!! $post->content !!}
          </div>

          {{-- PDF Embed --}}
          @if($post->pdf_url)
            <x-pdf-embed :pdfUrl="$post->pdf_url" :title="$post->pdf_title ?? 'View PDF Document'" />
          @endif

          {{-- Categories & Tags --}}
          <div class="mb-4">
            <p class="text-muted mt-2">
              Published on: {{ $post->published_at ? $post->published_at->format('d M Y') : 'N/A' }}
            </p>
          </div>
          @php
                // prefer relation — controller should eager-load user (see controller snippet below)
                $author = $post->user ?? null;
          @endphp

          <div class="card author-card">
            <div class="card-body d-flex gap-3 align-items-center">
                <div>
                    <strong>{{ $author->name ?? 'Author' }}</strong>
                </div>
            </div>
          </div>
          {{-- Share Buttons (styled) --}}
          <section class="post-share-author my-5">
            <div class="card shadow-sm mb-4">
              <div class="card-body text-center">
                <h5 class="card-title mb-3">📣 Share this post</h5>

                <div class="share-buttons d-flex flex-wrap justify-content-center gap-2">
                  <!-- WhatsApp -->
                  <a href="https://wa.me/?text={{ urlencode($post->title . ' - ' . url()->current()) }}"
                     target="_blank" rel="noopener noreferrer"
                     class="btn-share btn-share--whatsapp" title="Share on WhatsApp" aria-label="Share on WhatsApp">
                    <i class="bi bi-whatsapp" aria-hidden="true"></i>
                    <span class="btn-share__text">WhatsApp</span>
                  </a>

                  <!-- Facebook -->
                  <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                     target="_blank" rel="noopener noreferrer"
                     class="btn-share btn-share--facebook" title="Share on Facebook" aria-label="Share on Facebook">
                    <i class="bi bi-facebook" aria-hidden="true"></i>
                    <span class="btn-share__text">Facebook</span>
                  </a>

                  <!-- Email -->
                  <a href="mailto:?subject={{ urlencode('Check out this post: ' . $post->title) }}&body={{ urlencode(url()->current()) }}"
                     class="btn-share btn-share--email" title="Share by email" aria-label="Share by Email">
                    <i class="bi bi-envelope" aria-hidden="true"></i>
                    <span class="btn-share__text">Email</span>
                  </a>

                  <!-- Copy link -->
                  <button type="button" id="copyLinkBtn" data-url="{{ url()->current() }}"
                          class="btn-share btn-share--copy" title="Copy link" aria-label="Copy link to clipboard">
                    <i class="bi bi-clipboard" id="copyIcon" aria-hidden="true"></i>
                    <span class="btn-share__text" id="copyBtnText">Copy link</span>
                  </button>
                </div>
              </div>
            </div>
          </section>


          {{-- Toast (copy success) --}}
          <div id="shareToast" class="share-toast" aria-live="polite" aria-atomic="true" hidden>🔗 Link copied!</div>
          <div class="container mb-5">
                @include('partials.all-posts')
          </div>




        </div> {{-- .single-post --}}
      </div> {{-- .col-lg-8 posts-list --}}
      <!-- Sidebar -->
      <div class="col-lg-4">
        <div class="blog_right_sidebar">
          @include('partials.sidebar')
        </div>
      </div>
    </div> {{-- .row --}}
  </div> {{-- .container --}}
</section>
@endsection

@push('scripts')
<script>
// Wait for DOM to be fully loaded
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initializeAllFeatures);
} else {
  initializeAllFeatures();
}

function initializeAllFeatures() {
  initializeCopyButton();
}

function initializeCopyButton() {
  const copyBtn = document.getElementById('copyLinkBtn');
  const toast = document.getElementById('shareToast');
  const copyIcon = document.getElementById('copyIcon');
  const copyBtnText = document.getElementById('copyBtnText');

  function showToast(msg = 'Link copied!', time = 1600){
    if(!toast) return;
    toast.textContent = '✅ ' + msg;
    toast.hidden = false;
    toast.classList.add('show');
    setTimeout(()=>{ toast.classList.remove('show'); setTimeout(()=> toast.hidden = true, 220); }, time);
  }

  if(copyBtn){
    copyBtn.addEventListener('click', async () => {
      const url = copyBtn.dataset.url || window.location.href;
      try {
        if(navigator.clipboard && navigator.clipboard.writeText){
          await navigator.clipboard.writeText(url);
        } else { fallbackCopy(url); }

        copyBtnText.textContent = 'Copied';
        if(copyIcon){ copyIcon.classList.remove('bi-clipboard'); copyIcon.classList.add('bi-check-lg'); }
        showToast('Link copied to clipboard');

        setTimeout(() => {
          copyBtnText.textContent = 'Copy link';
          if(copyIcon){ copyIcon.classList.remove('bi-check-lg'); copyIcon.classList.add('bi-clipboard'); }
        }, 1400);
      } catch(e){
        const fallback = window.prompt('Copy this link', url);
        if(fallback !== null) showToast('Copied (fallback)');
      }
    });
  }

  function fallbackCopy(text){
    const txtarea = document.createElement('textarea');
    txtarea.value = text;
    txtarea.style.position = 'fixed';
    txtarea.style.left = '-9999px';
    document.body.appendChild(txtarea);
    txtarea.select();
    try { document.execCommand('copy'); } catch(e){}
    document.body.removeChild(txtarea);
  }
}
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
    console.log('Initializing sliders...');

    // Initialize News Ticker (with jQuery fallback)
    try {
        if (typeof $ !== 'undefined' && typeof $.fn.ticker !== 'undefined') {
            const newsTicker = $('#js-news');
            if (newsTicker.length) {
                newsTicker.ticker({
                    speed: 0.10,
                    controls: false,
                    titleText: '',
                    displayType: 'reveal',
                    direction: 'ltr',
                    pauseOnItems: 2000,
                    fadeInSpeed: 600,
                    fadeOutSpeed: 300
                });
            }
        }
    } catch(e) {
        console.warn('News ticker initialization failed:', e);
    }

    // Initialize Main Slider (with dots)
    initializeMainSlider();

    // Initialize Top-A Slider (horizontal banner)
    initializeTopASlider();

    // Initialize Top-Side Slider (sidebar)
    initializeTopSideSlider();
});

function initializeMainSlider() {
    const slides = document.querySelectorAll('.slide-item');
    const dots = document.querySelectorAll('.slider-dot');

    if (!slides.length) {
        console.log('No main slider items found');
        return;
    }

    let currentSlide = 0;
    let autoplayInterval;

    function showSlide(index) {
        slides.forEach((slide, i) => {
            slide.classList.remove('active');
            if (i === index) {
                slide.classList.add('active');
            }
        });

        dots.forEach((dot, i) => {
            dot.classList.remove('active');
            if (i === index) {
                dot.classList.add('active');
            }
        });
    }

    function nextSlide() {
        currentSlide = (currentSlide + 1) % slides.length;
        showSlide(currentSlide);
    }

    function startAutoplay() {
        if (autoplayInterval) clearInterval(autoplayInterval);
        autoplayInterval = setInterval(nextSlide, 4000);
    }

    function stopAutoplay() {
        if (autoplayInterval) clearInterval(autoplayInterval);
    }

    // Initialize first slide
    showSlide(0);

    // Dot click handlers
    dots.forEach((dot, index) => {
        dot.addEventListener('click', function() {
            stopAutoplay();
            currentSlide = index;
            showSlide(currentSlide);
            startAutoplay();
        });
    });

    // Pause on hover
    const sliderContainer = document.querySelector('.slider-container');
    if (sliderContainer) {
        sliderContainer.addEventListener('mouseenter', stopAutoplay);
        sliderContainer.addEventListener('mouseleave', startAutoplay);
    }

    // Start autoplay
    if (slides.length > 1) {
        startAutoplay();
    }

    console.log(`Main slider initialized with ${slides.length} slides`);
}

function initializeTopASlider() {
    const topASlides = document.querySelectorAll('.top-a-slide');

    if (!topASlides.length) {
        console.log('No top-a slider items found');
        return;
    }

    let currentTopASlide = 0;

    function showTopASlide(index) {
        topASlides.forEach((slide, i) => {
            slide.classList.remove('active');
            if (i === index) {
                slide.classList.add('active');
            }
        });
    }

    function nextTopASlide() {
        currentTopASlide = (currentTopASlide + 1) % topASlides.length;
        showTopASlide(currentTopASlide);
    }

    // Initialize first slide
    showTopASlide(0);

    // Auto-rotate every 5 seconds
    if (topASlides.length > 1) {
        setInterval(nextTopASlide, 5000);
    }

    console.log(`Top-A slider initialized with ${topASlides.length} slides`);
}

function initializeTopSideSlider() {
    const topSideSlides = document.querySelectorAll('.top-side-slide');

    if (!topSideSlides.length) {
        console.log('No top-side slider items found');
        return;
    }

    let currentTopSideSlide = 0;

    function showTopSideSlide(index) {
        topSideSlides.forEach((slide, i) => {
            slide.classList.remove('active');
            if (i === index) {
                slide.classList.add('active');
            }
        });
    }

    function nextTopSideSlide() {
        currentTopSideSlide = (currentTopSideSlide + 1) % topSideSlides.length;
        showTopSideSlide(currentTopSideSlide);
    }

    // Initialize first slide
    showTopSideSlide(0);

    // Auto-rotate every 6 seconds
    if (topSideSlides.length > 1) {
        setInterval(nextTopSideSlide, 6000);
    }

    console.log(`Top-Side slider initialized with ${topSideSlides.length} slides`);
}
</script>
@endpush
