<div class="container py-4">
    <div class="row">
        <div class="col-md-9">
            <div id="postCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @foreach($featuredPosts as $key => $post)
                        <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                            @if($post->image_path)
                                <img src="{{ asset('storage/' . $post->image_path) }}" 
                                    class="card-img-top" 
                                    alt="{{ $post->title }}"
                                    style="height: 400px; width: 800px; object-fit: cover;">
                            @else
                                <img src="{{ asset('images/logo_main.png') }}" 
                                    class="card-img-top" 
                                    alt="Default Image" 
                                    style="height: 400px; width: 800px; object-fit: cover;">
                            @endif
                            <div class="carousel-caption d-none d-md-block align-items-center" style="background: rgba(255, 255, 255, 0.8); width: fit-content; padding: 20px;">
                                <p style="color: rgb(255, 98, 0) ;font-weight: bold; font-size: 1.2rem;">
                                    {{ $post->published_at ? $post->published_at->format('d M Y') : '' }}
                                    {{ $post->title }}
                                </p>
                                <a href="{{ route('posts.show', $post->slug) }}" class="btn btn-sm btn-light">Read More</a>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#postCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#postCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            </div>
        </div>
        <div class="col-md-3" style="background: #ff4400; padding: 15px; border-radius: 5px;">
            <div class="card-header text-white">
                <strong>Latest Post</strong>
            </div>
            @foreach($latestPosts as $latest)
                <div class="card mb-3 shadow-sm">
                    <div class="card-body p-2">
                        <h6 class="card-title mb-1">{{ $latest->title }}</h6>
                        <a href="{{ route('posts.show', $latest->slug) }}" class="stretched-link"></a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
