@extends('landingpage.layout.blog')

@section('css')
    <link href="{{ asset('assets/landing/css/module-css/blog-sidebar.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/landing/css/module-css/blog-details.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/landing/css/module-css/subscribe.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/landing/css/module-css/page-title.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/landing/css/module-css/news.css') }}" rel="stylesheet">
@endsection

@section('content')
    <!-- page-title -->
    <section class="page-title centred pt_110">
        <div class="auto-container">
            <div class="content-box">
                <h1>{{ $blog->title }}</h1>
                <ul class="bread-crumb clearfix">
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li>-</li>
                    <li><a href="{{ route('blog.index') }}">Blog</a></li>
                    <li>-</li>
                    <li>Details</li>
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
                <!-- Sidebar (Same as Index) -->
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
                                            <a href="{{ route('blog.index', ['category' => $category->slug]) }}">
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
                    </div>
                </div>

                <!-- Content Side -->
                <div class="col-lg-8 col-md-12 col-sm-12 content-side">
                    <div class="blog-details-content">
                        <div class="news-block-two">
                            <div class="inner-box">
                                <div class="image-box">
                                    <figure class="image">
                                        <img src="{{ $blog->featured_image ? asset('storage/' . $blog->featured_image) : asset('assets/landing/images/news/news-15.jpg') }}" alt="{{ $blog->title }}" style="width: 100%; max-height: 500px; object-fit: cover;">
                                    </figure>
                                </div>
                                <div class="lower-content">
                                    <span class="category">{{ $blog->category->name ?? 'Uncategorized' }}</span>
                                    <h3>{{ $blog->title }}</h3>
                                    <ul class="post-info">
                                        <li>By <a href="#">{{ $blog->author->name ?? 'Admin' }}</a></li>
                                        <li><span>{{ $blog->published_at ? $blog->published_at->format('F d, Y') : $blog->created_at->format('F d, Y') }}</span></li>
                                    </ul>
                                </div>
                                <div class="text-box pt_25 mb_50">
                                    {!! $blog->content !!}
                                </div>
                            </div>
                        </div>

                        <div class="post-share-option mb_60">
                            @if($blog->meta_keywords)
                                <ul class="tags-list">
                                    <li><h6>Tags:</h6></li>
                                    @foreach(explode(',', $blog->meta_keywords) as $tag)
                                        <li><a href="#">{{ trim($tag) }}</a></li>
                                    @endforeach
                                </ul>
                            @endif
                            <ul class="social-links">
                                <li><h6>Share This :</h6></li>
                                <li><a href="#"><i class="icon-22"></i></a></li> <!-- Twitter -->
                                <li><a href="#"><i class="icon-23"></i></a></li> <!-- Facebook -->
                                <li><a href="#"><i class="icon-24"></i></a></li> <!-- Pinterest/Instagram -->
                            </ul>
                        </div>

                        @if(isset($relatedBlogs) && $relatedBlogs->count() > 0)
                            <div class="content-one mb_40">
                                <h3>Related Posts</h3>
                                <div class="row">
                                    @foreach($relatedBlogs as $related)
                                        <div class="col-md-6">
                                            <div class="news-block-two">
                                                <div class="inner-box">
                                                    <figure class="image-box">
                                                        <a href="{{ route('blog.show', $related->slug) }}">
                                                            <img src="{{ $related->featured_image ? asset('storage/' . $related->featured_image) : asset('assets/landing/images/news/news-1.jpg') }}" alt="" style="height: 200px; object-fit: cover;">
                                                        </a>
                                                    </figure>
                                                    <div class="lower-content">
                                                        <h6><a href="{{ route('blog.show', $related->slug) }}">{{ $related->title }}</a></h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- Comments Section removed for now as it requires backend implementation --}}
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- sidebar-page-container end -->
@endsection
