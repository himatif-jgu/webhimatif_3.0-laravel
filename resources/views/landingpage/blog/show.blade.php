@extends('landingpage.layout.master')

@section('title', $blog->meta_title ?: $blog->title . ' - HIMATIF')
@section('meta_description', $blog->meta_description ?: $blog->excerpt)
@section('meta_keywords', $blog->meta_keywords)

@section('content')
<!-- Page Title -->
<section class="page-title centred">
    <div class="bg-layer" style="background-image: url({{ asset('assets/landing/images/background/page-title.jpg') }});"></div>
    <div class="auto-container">
        <div class="content-box">
            <h2>{{ $blog->title }}</h2>
            <ul class="bread-crumb clearfix">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('blog.index') }}">Blog</a></li>
                <li>{{ Str::limit($blog->title, 30) }}</li>
            </ul>
        </div>
    </div>
</section>

<!-- Blog Details -->
<section class="blog-details p-relative pt-110 pb-120">
    <div class="auto-container">
        <div class="row clearfix">
            <!-- Sidebar -->
            <div class="col-lg-4 col-md-12 col-sm-12 sidebar-side">
                <div class="blog-sidebar mr-40">
                    <!-- Author Widget -->
                    <div class="sidebar-widget author-widget mb-50">
                        <div class="widget-content">
                            <div class="author-box">
                                @if($blog->author->avatar)
                                <figure class="author-thumb">
                                    <img src="{{ asset('storage/' . $blog->author->avatar) }}" alt="{{ $blog->author->name }}">
                                </figure>
                                @endif
                                <div class="author-text">
                                    <h4>{{ $blog->author->name }}</h4>
                                    <span class="designation">Author</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Categories Widget -->
                    <div class="sidebar-widget category-widget mb-50">
                        <div class="widget-title mb-11">
                            <h3>Categories</h3>
                        </div>
                        <div class="widget-content">
                            <ul class="category-list clearfix">
                                @foreach($categories as $category)
                                <li>
                                    <a href="{{ route('blog.index', ['category' => $category->slug]) }}" class="{{ $blog->category && $blog->category->id == $category->id ? 'active' : '' }}">
                                        {{ $category->name }}<span>({{ $category->active_blogs_count }})</span>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <!-- Recent Posts Widget -->
                    <div class="sidebar-widget post-widget mb-60">
                        <div class="widget-title mb-20">
                            <h3>Latest Posts</h3>
                        </div>
                        <div class="post-inner">
                            @foreach($recentPosts as $recentPost)
                            <div class="post">
                                @if($recentPost->featured_image)
                                <figure class="post-thumb">
                                    <a href="{{ route('blog.show', $recentPost->slug') }}">
                                        <img src="{{ asset('storage/' . $recentPost->featured_image) }}" alt="{{ $recentPost->title }}">
                                    </a>
                                </figure>
                                @endif
                                <h6><a href="{{ route('blog.show', $recentPost->slug') }}">{{ Str::limit($recentPost->title, 50) }}</a></h6>
                                <span class="post-date">{{ $recentPost->formatted_date }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Content Side -->
            <div class="col-lg-8 col-md-12 col-sm-12 content-side">
                <div class="blog-details-content">
                    <div class="news-block-one">
                        <div class="inner-box">
                            @if($blog->featured_image)
                            <figure class="image-box">
                                <img src="{{ asset('storage/' . $blog->featured_image) }}" alt="{{ $blog->title }}">
                            </figure>
                            @endif
                            <div class="lower-content">
                                <div class="post-info mb-20">
                                    <ul class="info clearfix">
                                        <li><i class="icon-27"></i>{{ $blog->formatted_date }}</li>
                                        @if($blog->category)
                                        <li><i class="icon-26"></i><a href="{{ route('blog.index', ['category' => $blog->category->slug]) }}">{{ $blog->category->name }}</a></li>
                                        @endif
                                        <li><i class="icon-28"></i>{{ $blog->author->name }}</li>
                                        <li><i class="icon-eye"></i>{{ number_format($blog->views_count) }} Views</li>
                                    </ul>
                                </div>
                                <h2>{{ $blog->title }}</h2>
                                
                                @if($blog->excerpt)
                                <div class="text mb-30">
                                    <p><strong>{{ $blog->excerpt }}</strong></p>
                                </div>
                                @endif

                                <div class="text">
                                    {!! $blog->content !!}
                                </div>

                                <!-- Social Share -->
                                <div class="post-share-option mt-40">
                                    <ul class="social-links clearfix">
                                        <li><h6>Share:</h6></li>
                                        <li><a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('blog.show', $blog->slug)) }}" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                                        <li><a href="https://twitter.com/intent/tweet?url={{ urlencode(route('blog.show', $blog->slug)) }}&text={{ urlencode($blog->title) }}" target="_blank"><i class="fab fa-twitter"></i></a></li>
                                        <li><a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(route('blog.show', $blog->slug)) }}" target="_blank"><i class="fab fa-linkedin-in"></i></a></li>
                                        <li><a href="https://api.whatsapp.com/send?text={{ urlencode($blog->title . ' - ' . route('blog.show', $blog->slug)) }}" target="_blank"><i class="fab fa-whatsapp"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Related Posts -->
                    @if($relatedBlogs->count() > 0)
                    <div class="related-post mt-60">
                        <div class="title mb-40">
                            <h3>Related Posts</h3>
                        </div>
                        <div class="row clearfix">
                            @foreach($relatedBlogs as $relatedBlog)
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="news-block-two">
                                    <div class="inner-box">
                                        @if($relatedBlog->featured_image)
                                        <figure class="image-box">
                                            <a href="{{ route('blog.show', $relatedBlog->slug') }}">
                                                <img src="{{ asset('storage/' . $relatedBlog->featured_image) }}" alt="{{ $relatedBlog->title }}">
                                            </a>
                                        </figure>
                                        @endif
                                        <div class="lower-content">
                                            <h5><a href="{{ route('blog.show', $relatedBlog->slug') }}">{{ Str::limit($relatedBlog->title, 50) }}</a></h5>
                                            <span class="post-date">{{ $relatedBlog->formatted_date }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
