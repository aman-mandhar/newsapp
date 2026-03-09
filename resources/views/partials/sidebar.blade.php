                  <aside class="single_sidebar_widget search_widget">
                     <form action="#">
                        <div class="form-group">
                           <div class="input-group mb-3">
                              <input type="text" class="form-control" placeholder='Search Keyword'
                                 onfocus="this.placeholder = ''" onblur="this.placeholder = 'Search Keyword'">
                              <div class="input-group-append">
                                 <button class="btns" type="button"><i class="ti-search"></i></button>
                              </div>
                           </div>
                        </div>
                        <button class="button rounded-0 primary-bg text-white w-100 btn_1 boxed-btn"
                           type="submit">News Search</button>
                     </form>
                  </aside>
                  <aside class="single_sidebar_widget post_category_widget">
                     <h4 class="widget_title">News as per Category</h4>
                     <ul class="list cat-list">
                        @php
                            // Fetch categories from the database
                            $categories = \App\Models\NewsCategory::orderBy('name')->get();
                        @endphp
                        @foreach($categories as $category)
                            <li><a href="{{ route('news-category.show', $category->slug) }}">{{ $category->name }}</a></li>
                        @endforeach
                     </ul>
                  </aside>
                  <aside class="single_sidebar_widget popular_post_widget">
                     <h3 class="widget_title">Recent Post</h3>
                     @php
                        // Fetch recent posts from the database
                        $recentPosts = \App\Models\Post::orderBy('created_at', 'desc')->take(12)->get();
                     @endphp
                     @foreach($recentPosts as $post)
                        <div class="media post_item">
                            <a href="{{ route('posts.show', $post->slug) ?? url('/news/'.$post->slug) }}">
                                {{-- Post Image --}}
                                @if($post->image_path)
                                <img src="{{ asset('storage/' . $post->image_path) }}"
                                    alt="{{ $post->title }}"
                                    loading="lazy"
                                    class="img-fluid mb-4 rounded"
                                    style="width: 80px; height: 80px; object-fit: cover;">
                                @endif
                                <div class="media-body">
                                    <h3>{{ $post->title }}</h3>
                                    <p>{{ $post->created_at->diffForHumans() }}</p>
                                </div>
                            </a>
                        </div>
                    @endforeach
                  </aside>
                  <aside class="single_sidebar_widget newsletter_widget">
                     <h4 class="widget_title">Newsletter</h4>
                     <a class="button rounded-0 primary-bg text-white w-100 btn_1 boxed-btn"
                        href="{{ route('register') }}">Join Now
                     </a>
                  </aside>
