@extends('landingpage.layout.blog')

@section('css')
    <link href="{{ asset('assets/landing/css/module-css/blog-sidebar.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/landing/css/module-css/subscribe.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/landing/css/module-css/page-title.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/landing/css/module-css/news.css') }}" rel="stylesheet">
@endsection

@section('content')
    <!-- page-title -->
    <section class="page-title centred pt_110">
        <div class="auto-container">
            <div class="content-box">
                <h1>Blog</h1>
                <ul class="bread-crumb clearfix">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li>-</li>
                    <li>Blog</li>
                </ul>
                <div class="mt-4">
                    <a href="{{ route('home') }}" class="theme-btn btn-one">Back to Home</a>
                </div>
            </div>
        </div>
    </section>
    <!-- page-title end -->


    <!-- sidebar-page-container -->
    <section class="sidebar-page-container p_relative pt_110 pb_120">
        <div class="auto-container">
            <div class="row clearfix">
                <!-- Sidebar -->
                <div class="col-lg-4 col-md-12 col-sm-12 sidebar-side">
                    <div class="blog-sidebar mr_40 mb_30">
                        <div class="search-widget mb_60">
                            <div class="search-form">
                                <form method="get" action="{{ route('blog.index') }}">
                                    <div class="form-group">
                                        <input type="search" name="search" placeholder="Search" value="{{ request('search') }}" required>
                                        <button type="submit"><i class="icon-1"></i></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="sidebar-widget category-widget mb_50">
                            <div class="widget-title mb_11">
                                <h3>Categories</h3>
                            </div>
                            <div class="widget-content">
                                <ul class="category-list clearfix">
                                    @foreach($categories as $category)
                                        <li>
                                            <a href="{{ route('blog.index', ['category' => $category->slug]) }}"
                                               class="{{ request('category') == $category->slug ? 'active' : '' }}">
                                                {{ $category->name }}<span>({{ $category->active_blogs_count }})</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="sidebar-widget post-widget mb_60">
                            <div class="widget-title mb_20">
                                <h3>Latest Posts</h3>
                            </div>
                            <div class="post-inner">
                                @foreach($recentPosts as $post)
                                    <div class="post">
                                        <figure class="post-thumb">
                                            <a href="{{ route('blog.show', $post->slug) }}">
                                                <img src="{{ $post->featured_image ? asset('storage/' . $post->featured_image) : asset('assets/landing/images/news/post-1.jpg') }}" alt="{{ $post->title }}">
                                            </a>
                                        </figure>
                                        <h6><a href="{{ route('blog.show', $post->slug) }}">{{ Str::limit($post->title, 40) }}</a></h6>
                                        <span class="post-date">{{ $post->published_at ? $post->published_at->format('d M Y') : $post->created_at->format('d M Y') }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        {{--
                        <div class="sidebar-widget tags-widget mb_45">
                            <div class="widget-title mb_20">
                                <h3>Popular tag</h3>
                            </div>
                            <div class="widget-content">
                                <ul class="tags-list clearfix">
                                    <li><a href="blog-details.html">Account</a></li>
                                    <li><a href="blog-details.html">Careers</a></li>
                                </ul>
                            </div>
                        </div>
                        --}}
                    </div>
                </div>

                <!-- Content Side -->
                <div class="col-lg-8 col-md-12 col-sm-12 content-side">
                    <div class="blog-grid-content">
                        <div class="row clearfix">
                            @forelse($blogs as $blog)
                                <div class="col-lg-6 col-md-6 col-sm-12 news-block">
                                    <div class="news-block-two wow fadeInUp animated" data-wow-delay="00ms" data-wow-duration="1500ms">
                                        <div class="inner-box">
                                            <div class="image-box">
                                                <figure class="image">
                                                    <a href="{{ route('blog.show', $blog->slug) }}">
                                                        <img src="{{ $blog->featured_image ? asset('storage/' . $blog->featured_image) : asset('assets/landing/images/news/news-4.jpg') }}" alt="{{ $blog->title }}" style="height: 250px; object-fit: cover;">
                                                    </a>
                                                </figure>
                                                <figure class="overlay-image">
                                                    <a href="{{ route('blog.show', $blog->slug) }}">
                                                        <img src="{{ $blog->featured_image ? asset('storage/' . $blog->featured_image) : asset('assets/landing/images/news/news-4.jpg') }}" alt="{{ $blog->title }}" style="height: 250px; object-fit: cover;">
                                                    </a>
                                                </figure>
                                            </div>
                                            <div class="lower-content">
                                                <span class="category">{{ $blog->category->name ?? 'Uncategorized' }}</span>
                                                <h3><a href="{{ route('blog.show', $blog->slug) }}">{{ $blog->title }}</a></h3>
                                                <ul class="post-info">
                                                    <li>By <a href="#">{{ $blog->author->name ?? 'Admin' }}</a></li>
                                                    <li><span>{{ $blog->published_at ? $blog->published_at->format('F d, Y') : $blog->created_at->format('F d, Y') }}</span></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12">
                                    <div class="alert alert-info">No blogs found.</div>
                                </div>
                            @endforelse
                        </div>

                        <div class="pagination-wrapper">
                            {{ $blogs->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- sidebar-page-container end -->
@endsection
