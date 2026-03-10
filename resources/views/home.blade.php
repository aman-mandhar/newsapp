@extends('layouts.portal.view')

@push('styles')
<style>
:root {
    --primary-color: #000000;
    --secondary-color: #FF0000;
    --bg-main: #ffffff;
    --text-color: #000000;
    --card-bg: #FFFFFF;
    --border-color: #000000;
}

body {
    background: #ffffff !important;
    color: #000000 !important;
}

main {
    background: #ffffff;
}

/* Trending Area Styling */
.trending-area {
    background: #ffffff;
    padding: 20px 0;
}

.trending-tittle {
    background: white;
    border: 2px solid #000000;
    border-radius: 12px;
    padding: 15px 20px;
    margin-bottom: 30px;
    display: flex;
    align-items: center;
    gap: 15px;
}

.trending-tittle strong {
    background: #FF0000;
    color: white;
    font-size: 1rem;
    font-weight: 700;
    padding: 8px 20px;
    border-radius: 8px;
    white-space: nowrap;
}

.trending-animated {
    flex: 1;
    overflow: hidden;
    position: relative;
    height: 30px;
}

.trending-animated .news-item {
    color: #000000 !important;
    font-weight: 500;
}

.trending-animated #js-news {
    list-style: none;
    margin: 0;
    padding: 0;
}

.trending-animated .js-hidden {
    display: block !important;
}

/* Ticker Styles */
.ticker {
    position: relative;
    overflow: hidden;
    height: 30px;
    line-height: 30px;
}

.ticker-wrapper.has-js {
    margin: 0;
    padding: 0;
}

.ticker-title,
.ticker-controls {
    display: none !important;
}

.ticker-content {
    margin: 0;
    padding: 0;
    position: relative;
    overflow: hidden;
}

.ticker-swipe {
    padding: 0;
    margin: 0;
}

.ticker-swipe span {
    margin: 0;
    padding: 0;
}

.ticker li {
    color: #000000 !important;
    font-weight: 500;
    font-size: 1rem;
    padding: 0 20px 0 0;
    display: inline;
}

.ticker a {
    color: #000000 !important;
    text-decoration: none;
}

.ticker a:hover {
    color: #FF0000 !important;
}

/* Right Sidebar Container */
.col-lg-4 {
    padding-left: 15px;
}

.col-lg-8 {
    padding-right: 15px;
}

/* Featured Post */
.trending-top {
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 4px 16px rgba(0,0,0,0.12);
    border: 2px solid #000000;
    height: 550px;
    position: relative;
}

.slider-container {
    position: relative;
    height: 550px;
    width: 100%;
}

.slide-item {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    transition: opacity 1.5s ease-in-out;
    z-index: 1;
}

.slide-item.active {
    opacity: 1;
    z-index: 2;
}

.trend-top-img {
    height: 550px;
    position: relative;
}

.trend-top-img img {
    width: 100%;
    height: 550px;
    object-fit: cover;
}

.trend-top-cap {
    background: rgba(0, 0, 0, 0.85) !important;
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 25px;
}

.trend-top-cap span {
    background: #FF0000 !important;
    color: white !important;
    padding: 6px 16px;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.9rem;
    display: inline-block;
    margin-bottom: 10px;
}

.trend-top-cap h2 {
    margin: 0;
}

.trend-top-cap h2 a {
    color: white !important;
    font-weight: 700;
    font-size: 1.5rem;
    line-height: 1.4;
}

.trend-top-cap h2 a:hover {
    color: #ffffff !important;
}

/* Slider Navigation Dots */
.slider-dots {
    position: absolute;
    bottom: 20px;
    right: 20px;
    display: flex;
    gap: 10px;
    z-index: 10;
}

.slider-dot {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.5);
    cursor: pointer;
    transition: all 0.3s;
    border: 2px solid white;
}

.slider-dot.active {
    background: #FF0000;
    transform: scale(1.2);
}

/* Trending Bottom Section */
.trending-bottom {
    margin-top: 30px;
}

.trending-bottom .col-lg-4 {
    padding: 0 10px;
    margin-bottom: 20px;
}

/* Trending Bottom Cards */
.single-bottom {
    background: white;
    border: 2px solid #000000;
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.3s;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    height: 100%;
    display: flex;
    flex-direction: column;
}

.single-bottom:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.15);
}

.trend-bottom-img {
    margin-bottom: 0 !important;
    border-bottom: 2px solid #000000;
    height: 200px;
    overflow: hidden;
}

.trend-bottom-img img {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.trend-bottom-cap {
    padding: 15px;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.trend-bottom-cap span {
    background: #FF0000 !important;
    color: white !important;
    padding: 5px 14px;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: 600;
    display: inline-block;
    margin-bottom: 10px;
    width: fit-content;
}

.trend-bottom-cap h4 {
    margin: 0;
    flex: 1;
}

.trend-bottom-cap h4 a {
    color: #000000 !important;
    font-weight: 600;
    line-height: 1.5;
    font-size: 1rem;
}

.trend-bottom-cap h4 a:hover {
    color: #FF0000 !important;
}

/* Sidebar Posts */
.trand-right-single {
    background: white;
    border: 2px solid #000000;
    border-radius: 12px;
    padding: 12px;
    transition: all 0.3s;
    margin-bottom: 15px !important;
}

.trand-right-single:hover {
    transform: translateX(5px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.trand-right-img {
    border: 2px solid #000000;
    border-radius: 8px;
    overflow: hidden;
    width: 90px !important;
    height: 90px !important;
    flex-shrink: 0;
}

.trand-right-img img {
    width: 90px !important;
    height: 90px !important;
    object-fit: cover;
}

.trand-right-cap {
    flex: 1;
    padding-left: 12px;
}

.trand-right-cap span {
    background: #FF0000 !important;
    color: white !important;
    padding: 4px 12px;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
    display: inline-block;
    margin-bottom: 8px;
}

.trand-right-cap h4 {
    margin: 0;
}

.trand-right-cap h4 a {
    color: #000000 !important;
    font-weight: 600;
    font-size: 0.95rem;
    line-height: 1.4;
}

.trand-right-cap h4 a:hover {
    color: #FF0000 !important;
}

/* Section Titles */
.section-tittle h3,
.category-title {
    color: #FF0000 !important;
    font-weight: 700;
    padding-bottom: 10px;
    border-bottom: 3px solid #000000;
    display: inline-block;
}

/* Weekly News */
.weekly-news-area {
    background: #ffffff;
}

.weekly-single {
    background: white;
    border: 2px solid #000000;
    border-radius: 12px;
    overflow: hidden;
    margin: 0 10px;
    transition: all 0.3s;
}

.weekly-single:hover {
    transform: scale(1.02);
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
}

.weekly-caption {
    padding: 15px;
}

.weekly-caption span {
    background: #FF0000 !important;
    color: white !important;
    padding: 5px 12px;
    border-radius: 15px;
    font-weight: 600;
}

.weekly-caption h4 a {
    color: #000000 !important;
    font-weight: 600;
}

.weekly-caption h4 a:hover {
    color: #FF0000 !important;
}

/* Whats New Section */
.whats-news-area {
    background: #ffffff;
}

.single-what-news {
    background: white;
    border: 2px solid #000000;
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.3s;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
}

.single-what-news:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.15);
}

.what-img {
    border-bottom: 2px solid #000000;
}

.what-cap {
    padding: 15px;
}

.what-cap span {
    background: #FF0000 !important;
    color: white !important;
    padding: 4px 12px;
    border-radius: 15px;
    font-size: 0.85rem;
    font-weight: 600;
}

.what-cap h4 a {
    color: #000000 !important;
    font-weight: 600;
}

.what-cap h4 a:hover {
    color: #FF0000 !important;
}

/* YouTube Area */
.youtube-area {
    background: #ffffff;
}

.video-items iframe {
    border: 3px solid #000000;
    border-radius: 12px;
}

.video-caption {
    background: white;
    border: 2px solid #000000;
    border-radius: 12px;
    padding: 25px;
}

.video-caption .top-caption span {
    background: #FF0000 !important;
    color: white !important;
    padding: 6px 15px;
    border-radius: 20px;
    font-weight: 600;
}

.video-caption h2 {
    color: #000000 !important;
    font-weight: 700;
    margin-top: 15px;
}

.video-caption p {
    color: #000000 !important;
}

.single-video {
    background: white;
    border: 2px solid #000000;
    border-radius: 12px;
    overflow: hidden;
    margin-bottom: 15px;
}

.video-intro {
    padding: 12px;
    background: white;
}

.video-intro h4 {
    color: #000000 !important;
    font-weight: 600;
    font-size: 0.95rem;
    margin: 0;
}

/* Category Links */
.category-title a {
    color: #FF0000 !important;
    text-decoration: none !important;
}

.category-title a:hover {
    color: #000000 !important;
}

/* Horizontal Rule */
hr {
    border-color: #000000 !important;
    opacity: 0.3;
}

/* Alert Boxes */
.alert-info {
    background: white !important;
    border: 2px solid #000000 !important;
    color: #000000 !important;
    border-radius: 12px;
}

/* Color Classes Override */
.color1 {
    background: #FF0000 !important;
    color: white !important;
}

.color2 {
    background: #000000 !important;
    color: white !important;
}

.color3 {
    background: #FF0000 !important;
    color: white !important;
}

.color4 {
    background: #000000 !important;
    color: white !important;
}

/* Container Background */
.container {
    background: transparent;
}

/* Logo Slider Styles */
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
    object-fit: cover;
    opacity: 0;
    transition: opacity 1s ease-in-out;
}

.top-a-slide.active {
    opacity: 1;
}

/* Top Side Slider Styles (Right Sidebar) */
.top-side-slider {
    position: relative;
    width: 100%;
    height: 450px;
    overflow: hidden;
    border: 2px solid #000000;
    border-radius: 12px;
    box-shadow: 0 4px 16px rgba(0,0,0,0.12);
    background: white;
}

.top-side-slide {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    transition: opacity 1s ease-in-out;
}

.top-side-slide.active {
    opacity: 1;
}

/* Responsive Styles */
@media (max-width: 991px) {
    .trending-top {
        height: 400px;
    }

    .slider-container {
        height: 400px;
    }

    .trend-top-img {
        height: 400px;
    }

    .trend-top-img img {
        height: 400px;
    }

    .col-lg-4 {
        padding-left: 15px;
        margin-top: 30px;
    }

    .col-lg-8 {
        padding-right: 15px;
    }

    .top-side-slider {
        height: 350px;
    }
}

@media (max-width: 767px) {
    .trending-tittle {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }

    .trending-tittle strong {
        font-size: 0.9rem;
        padding: 6px 15px;
    }

    .trending-top {
        height: 260px;
    }

    .slider-container {
        height: 260px;
    }

    .trend-top-img {
        height: 260px;
    }

    .trend-top-img img {
        height: 260px;
    }

    .trend-top-cap {
        padding: 15px;
    }

    .trend-top-cap h2 a {
        font-size: 1.1rem;
    }

    .slider-dots {
        bottom: 10px;
        right: 10px;
        gap: 7px;
    }

    .slider-dot {
        width: 10px;
        height: 10px;
        border-width: 1px;
    }

    .trend-bottom-img {
        height: 180px;
    }

    .trend-bottom-img img {
        height: 180px;
    }

    .trand-right-img {
        width: 80px !important;
        height: 80px !important;
    }

    .trand-right-img img {
        width: 80px !important;
        height: 80px !important;
    }

    .top-side-slider {
        height: 300px;
        margin-top: 20px;
    }

    /* top-b-slider */
    .top-b-slider {
    width: min(1080px, calc(100vw - 40px));
    display: block;
    margin: 0 auto 30px;
    overflow: hidden;
    }

    .top-b-slider img {
    width: 100%;
    max-width: 100%;
    display: block;
    height: auto;
    transition: transform 0.3s ease;
    margin-bottom: 0;
    }

    @media (max-width: 576px) {
    .top-b-slider {
        width: calc(100vw - 24px);
    }
    }
    .top-b-slider:hover img {
    transform: scale(1.05);
    }
}
</style>
@endpush

@section('content')

<main>
    <!-- Trending Area Start -->
    <div class="trending-area fix">
        <div class="container">
            <div class="trending-main">
                <!-- 10 Recent Posts in ticker -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="trending-tittle">
                            <strong>Top Headlines</strong>
                            <div class="trending-animated">
                                <ul id="js-news" class="js-hidden">
                                    @foreach($topHeadlines as $headline)
                                        <li class="news-item"><a href="{{ route('posts.show', $headline->slug) }}">{{ $headline->title }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <!-- Trending Top Slider -->
                        <div class="trending-top mb-30">
                            <div class="slider-container">
                                @php
                                    $featuredSlides = \App\Models\Post::with(['categories:id,name'])
                                        ->where('status', 'published')
                                        ->latest('published_at')
                                        ->take(5)
                                        ->get();
                                @endphp

                                @foreach($featuredSlides as $slide)
                                    <div class="slide-item @if($loop->first) active @endif">
                                        <div class="trend-top-img">
                                            <img src="{{ $slide->image_path ? asset('storage/'.$slide->image_path) : asset('portal/assets/img/trending/trending_top.jpg') }}" alt="{{ $slide->title }}">
                                            <div class="trend-top-cap">
                                                @if($slide->categories->first())
                                                    <span>{{ $slide->categories->first()->name }}</span>
                                                @endif
                                                <h2><a href="{{ route('posts.show', $slide->slug) }}">{{ $slide->title }}</a></h2>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                @if($featuredSlides->count() > 1)
                                    <div class="slider-dots">
                                        @foreach($featuredSlides as $slide)
                                            <div class="slider-dot @if($loop->first) active @endif" data-slide="{{ $loop->index }}"></div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Trending Area End -->
    <!-- Whats New Start -->
    <section class="whats-news-area pt-50 pb-20">
        <div class="container">
             <!-- Dynamic Category Cards -->
            @forelse($whatsNewCategories as $catSection)
                <div class="category-cards-section mb-5">
                    <div class="row mb-4">
                        <div class="col-lg-12">
                            <h4 class="category-title text-uppercase">
                                <a href="{{ route('news-category.show', $catSection['category']->slug) }}" class="text-decoration-none">
                                    {{ $catSection['category']->name }}
                                </a>
                            </h4>
                        </div>
                    </div>
                    <div class="row">
                        @foreach($catSection['posts'] as $post)
                            <div class="col-lg-4 col-md-6 mb-50">
                                <div class="single-what-news">
                                    <div class="what-img align-items-center justify-content-center d-flex">
                                        <img src="{{ $post->image_path ? asset('storage/'.$post->image_path) : asset('portal/assets/img/news/whatNews1.jpg') }}" alt="{{ $post->title }}" style="height: 200px; width: auto;">
                                    </div>
                                    <div class="what-cap">
                                        @if($post->categories->first())
                                            <span class="color{{ ($loop->index % 3) + 1 }}">{{ $post->categories->first()->name }}</span>
                                        @endif
                                        <h4><a href="{{ route('posts.show', $post->slug) }}">{{ \Illuminate\Support\Str::limit($post->title, 80) }}</a></h4>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <hr class="my-5">
            @empty
                <div class="alert alert-info">
                    No categories available yet.
                </div>
            @endforelse
        </div>
    </section>
    <!-- Whats New End -->
</main>
    <!-- Main End -->
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize News Ticker
    if (typeof $.fn.ticker !== 'undefined') {
        $('#js-news').ticker({
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

    // Slider functionality
    const slides = document.querySelectorAll('.slide-item');
    const dots = document.querySelectorAll('.slider-dot');

    if (slides.length <= 1) return; // No slider if only one slide

    let currentSlide = 0;
    let autoplayInterval;

    function showSlide(index) {
        // Remove active class from all slides and dots
        slides.forEach(slide => slide.classList.remove('active'));
        dots.forEach(dot => dot.classList.remove('active'));

        // Add active class to current slide and dot
        slides[index].classList.add('active');
        if (dots[index]) dots[index].classList.add('active');
    }

    function nextSlide() {
        currentSlide = (currentSlide + 1) % slides.length;
        showSlide(currentSlide);
    }

    function startAutoplay() {
        autoplayInterval = setInterval(nextSlide, 4000); // Change slide every 4 seconds
    }

    function stopAutoplay() {
        clearInterval(autoplayInterval);
    }

    // Dot click handlers
    dots.forEach((dot, index) => {
        dot.addEventListener('click', function() {
            stopAutoplay();
            currentSlide = index;
            showSlide(currentSlide);
            startAutoplay(); // Resume autoplay after manual change
        });
    });

    // Pause on hover
    const sliderContainer = document.querySelector('.slider-container');
    if (sliderContainer) {
        sliderContainer.addEventListener('mouseenter', stopAutoplay);
        sliderContainer.addEventListener('mouseleave', startAutoplay);
    }

    // Start autoplay
    startAutoplay();

    // Top-A Slider functionality (horizontal banner)
    const topASlides = document.querySelectorAll('.top-a-slide');
    if (topASlides.length > 1) {
        let currentTopASlide = 0;

        function showTopASlide(index) {
            topASlides.forEach(slide => slide.classList.remove('active'));
            topASlides[index].classList.add('active');
        }

        function nextTopASlide() {
            currentTopASlide = (currentTopASlide + 1) % topASlides.length;
            showTopASlide(currentTopASlide);
        }

        // Auto-rotate every 5 seconds
        setInterval(nextTopASlide, 5000);
    }

    // Top-Side Slider functionality (right sidebar)
    const topSideSlides = document.querySelectorAll('.top-side-slide');
    if (topSideSlides.length > 1) {
        let currentTopSideSlide = 0;

        function showTopSideSlide(index) {
            topSideSlides.forEach(slide => slide.classList.remove('active'));
            topSideSlides[index].classList.add('active');
        }

        function nextTopSideSlide() {
            currentTopSideSlide = (currentTopSideSlide + 1) % topSideSlides.length;
            showTopSideSlide(currentTopSideSlide);
        }

        // Auto-rotate every 6 seconds (different timing from top-a)
        setInterval(nextTopSideSlide, 6000);
    }
});
</script>
@endpush
