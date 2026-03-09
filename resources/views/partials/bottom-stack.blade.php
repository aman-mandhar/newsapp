<div class="bottom-stack">
    {{-- Ticker --}}
    <div class="ticker">
        <div class="ticker-track">
            @php
                $tickerPosts = \App\Models\Post::where('status', 'published')->latest()->take(10)->get();
            @endphp
            @foreach($tickerPosts as $tickerPost)
                <a href="{{ route('single-layout', $tickerPost) }}">{{ $tickerPost->title }}</a>
            @endforeach
        </div>
    </div>

    {{-- Ads --}}
    <section class="ad-row">
        <div class="ad-box">
            <h3 style="text-align:center; padding:10px; font-size:16px; color:#000076;">Ad Space</h3>
        </div>
        <a class="ad-box" href="{{ route('welcome') }}" aria-label="Ad">
            <img src="{{ asset('images/add.png') }}" style="width:150px; height:150px;" alt="Logo">
        </a>
    </section>

    {{-- Quick Buttons --}}
    <div class="quick-row">
        <a href="{{ route('sikh.page') }}">Panthak Directory</a>
        <a href="{{ route('job.page') }}">Job Seekers</a>
        <a href="{{ route('biz.page') }}">Business Directory</a>
        <a href="{{ route('matrimonial.page') }}">Matrimonial</a>
        <a href="{{ route('posts.all') }}">News</a>
    </div>
</div>