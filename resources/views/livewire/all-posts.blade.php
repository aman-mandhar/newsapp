<div class="container py-5">
    <h2 class="mb-4 fw-bold text-success">All Posts</h2>

    <div class="row">
        @forelse($posts as $post)
            <div class="col-md-4 mb-4" wire:key="post-{{ $post->id }}">
                <div class="card h-100 shadow-sm">
                    @if($post->image_path)
                        <img src="{{ asset('storage/' . $post->image_path) }}" class="card-img-top" alt="{{ $post->title }}" style="height:200px;object-fit:cover;">
                    @else
                        <img src="{{ asset('images/logo_main.png') }}" class="card-img-top" alt="Default Image" style="height:200px;object-fit:cover;">
                    @endif

                    <div class="card-body">
                        <h5 class="card-title">{{ $post->title }}</h5>
                        <p class="card-text small text-muted">
                            {{ optional($post->published_at)->format('d M Y') }}
                        </p>
                        <p class="card-text">
                            <strong>Category:</strong>
                            @foreach($post->categories as $category)
                                <span class="badge bg-primary">{{ $category->name }}</span>
                            @endforeach
                        </p>
                        <a href="{{ route('posts.show', $post->slug) }}" class="btn btn-sm btn-success">Read More</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center">
                <p>No posts found.</p>
            </div>
        @endforelse
    </div>
    <div class="mt-4">
        {{ $posts->onEachSide(1)->links() }}
    </div>
</div>
