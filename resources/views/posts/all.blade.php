@extends('layouts.portal.view')
@section('content')
<style>
        /* ---------- Newspaper Vibes ---------- */
        .news-block .section-head {
            display:flex; align-items:center; justify-content:space-between; margin-bottom:.75rem;
        }
        .news-block .section-head h2 {
            margin:0; font-weight:700; letter-spacing:.2px;
            font-family: "Georgia", "Times New Roman", serif;
            border-bottom: 2px solid #e6e6e6; padding-bottom:.25rem;
        }
        .news-grid .card {
            border: 1px solid #eee; border-radius: 10px; overflow:hidden;
            transition: transform .15s ease, box-shadow .15s ease, border-color .15s ease;
            background: #fff;
        }
        .news-grid .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 22px rgba(0,0,0,.07);
            border-color:#e1e1e1;
        }

        /* Image as fixed ratio like print crops */
        .news-cover {
            position: relative; width:100%;
            aspect-ratio: 16/9; /* modern browsers */
            overflow:hidden; background:#f7f7f7;
        }
        .news-cover img {
            position:absolute; inset:0; width:100%; height:100%; object-fit:cover;
            transition: transform .4s ease;
        }
        .news-grid .card:hover .news-cover img { transform: scale(1.03); }

        /* Category ribbon like section slugs in papers */
        .cat-ribbon {
            position:absolute; top:10px; left:10px;
            background: #198754; color:#fff; font-size:.72rem; font-weight:700;
            padding:.25rem .5rem; border-radius: 6px;
            text-transform: uppercase; letter-spacing:.6px;
        }

        /* Card body = tight headline + muted meta + short dek */
        .news-card-body { padding: .85rem .9rem; text-align:left; }
        .news-title a {
            color:#111; text-decoration:none; font-weight:800;
            font-family: "Georgia", "Times New Roman", serif;
            line-height:1.15; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;
            min-height: 2.4em;
        }
        .news-meta {
            color:#6c757d; font-size:.8rem;
            display:flex; flex-wrap:wrap; gap:.5rem; align-items:center; margin-top:.4rem; margin-bottom:.4rem;
        }
        .news-meta .dot::before { content:"•"; margin:0 .4rem; color:#adb5bd; }
        .news-excerpt {
            color:#333; font-size:.93rem; line-height:1.45;
            display:-webkit-box; -webkit-line-clamp:3; -webkit-box-orient:vertical; overflow:hidden;
            margin-top:.35rem;
        }

        /* Badges like column tags */
        .news-tags { margin-top:.6rem; display:flex; flex-wrap:wrap; gap:.35rem; }
        .news-tag { background:#f0f7f3; color:#198754; border:1px solid #d9efe2; font-size:.72rem; padding:.15rem .45rem; border-radius:999px; }

        /* Footer */
        .news-card-footer { background:#fff; border-top:1px solid #f0f0f0; padding:.7rem .9rem; display:flex; justify-content:space-between; align-items:center; }
        .news-read { font-weight:600; }

        /* Empty state */
        .news-empty {
            background:#fff; border:1px dashed #d9d9d9; padding:1rem; border-radius:10px; color:#6c757d;
        }

        /* Small tweaks for mobile density */
        @media (max-width: 576px) {
            .news-card-body { padding:.75rem .8rem; }
            .news-card-footer { padding:.6rem .8rem; }
        }
    </style>

    <div class="container my-4">
        <div class="news-block">
            {{-- HERO + QUICK SEARCH --}}
            <form action="{{ route('search-post') }}" method="GET" class="d-flex gap-2">
                <div class="row align-items-center col-lg-12 mb-4">
                    <div class="col-lg-10">
                        <div class="p-4 rounded-3 bg-light border">
                            <input name="q" type="text" class="form-control" placeholder="Political / Crime / Sports....">
                        </div>
                    </div>
                    <div class="col-lg-2 d-none d-lg-block">
                        <div class="p-4 rounded-3">
                            <button type="submit" class="btn btn-success w-100 h-100">
                                <i class="bi bi-search"></i> Search
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            <div class="section-head">
                <h2 class="h5 mb-0">Latest News</h2>
                <a href="{{ route('posts.all') }}" class="btn btn-sm btn-outline-success">View all</a>
            </div>

            <div class="row g-3 mb-4 news-grid">
                @forelse($posts as $post)
                    @php
                        $img = $post->image_path ? asset('storage/'.$post->image_path) : asset('images/logo_main.png');
                        $firstCat = $post->categories->first();
                        // Check if authenticated user's id is $post->user_id to show edit link if status is draft
                        $authUser = Auth::user();
                    @endphp
                    <div class="col-12 col-md-6 col-lg-3">
                        <div>
                            @if ($post->status === 'draft' && $authUser && $authUser->id === $post->user_id)
                                <a href="{{ route('posts.edit', $post->slug) }}" class="btn btn-sm btn-warning" title="Edit Draft">Edit Draft</a>
                            @endif
                        </div>
                        <article class="card h-100">
                            <a href="{{ route('posts.show', $post->slug) }}" class="text-decoration-none">
                                <div class="news-cover">
                                    <img src="{{ $img }}" alt="{{ $post->title }}">
                                    @if($firstCat)
                                        <span class="cat-ribbon">{{ $firstCat->name }}</span>
                                    @endif
                                </div>
                            </a>

                            <div class="news-card-body">
                                <h3 class="news-title h6 mb-1">
                                    <a href="{{ route('posts.show', $post->slug) }}">
                                        {{ $post->title }}
                                    </a>
                                </h3>

                                <div class="news-meta">
                                    <span>{{ optional($post->published_at)->format('d M Y') }}</span>
                                    <span class="dot"></span>
                                    <span><i class="bi bi-eye"></i> {{ $post->views_count }} Views |</span>
                                </div>

                                <p class="news-excerpt mb-0">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($post->content ?? ''), 140) }}
                                </p>

                                @if($post->categories->isNotEmpty())
                                    <div class="news-tags">
                                        @foreach($post->categories->take(3) as $cat)
                                            <span class="news-tag">{{ $cat->name }}</span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            <div class="news-card-footer">
                                <a href="{{ route('posts.show', $post->slug) }}" class="small text-muted text-decoration-none">Full story →</a>
                            </div>
                        </article>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="news-empty text-center">
                            No posts yet. Jab tak naya edition aata hai, <a href="{{ route('posts.all') }}">archives</a> dekh lo. :)
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
        <div class="d-flex justify-content-center">
            {{ $posts->links() }}
        </div>
    </div>

@endsection
