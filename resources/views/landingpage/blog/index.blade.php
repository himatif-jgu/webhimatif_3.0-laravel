@extends('landingpage.layout.master')

@section('title', 'Blog - HIMATIF')

@section('content')
<!-- Page Title -->
<section class="page-title centred">
    <div class="bg-layer" style="background-image: url({{ asset('assets/landing/images/background/page-title.jpg') }});"></div>
    <div class="auto-container">
        <div class="content-box">
            <h2>Blog & News</h2>
            <ul class="bread-crumb clearfix">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li>Blog</li>
            </ul>
        </div>
    </div>
</section>

<!-- Sidebar Page Container -->
<section class="sidebar-page-container pt-110 pb-120">
    <div class="auto-container">
        <div class="row clearfix">
            <!-- Sidebar -->
            <div class="col-lg-4 col-md-12 col-sm-12 sidebar-side">
                <div class="blog-sidebar mr-40 mb-30">
                    <!-- Search Widget -->
                    <div class="search-widget mb-60">
                        <div class="search-form">
                            <form method="get" action="{{ route('blog.index') }}">
                                <div class="form-group">
                                    <input type="search" name="search" placeholder="Search..." value="{{ request('search') }}">
                                    <button type="submit"><i class="icon-1"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Categories Widget -->
                    <div class="sidebar-widget category-widget mb-50">
                        <div class="widget-title mb-11">
                            <h3>Categories</h3>
                        </div>
                        <div class="widget-content">
                            <ul class="category-list clearfix">
                                <li>
                                    <a href="{{ route('blog.index') }}" class="{{ !request('category') ? 'active' : '' }}">
                                        All Posts<span>({{ \App\Models\Blog::published()->count() }})</span>
                                    </a>
                                </li>
                                @foreach($categories as $category)
                                <li>
                                    <a href="{{ route('blog.index', ['category' => $category->slug]) }}" class="{{ request('category') == $category->slug ? 'active' : '' }}">
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
                                    <a href="{{ route('blog.show', $recentPost->slug) }}">
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
                <div class="blog-grid-content">
                    <div class="row clearfix">
                        @forelse($blogs as $blog)
                        <div class="col-lg-6 col-md-6 col-sm-12 news-block">
                            <div class="news-block-two wow fadeInUp animated" data-wow-delay="00ms" data-wow-duration="1500ms">
                                <div class="inner-box">
                                    @if($blog->featured_image)
                                    <figure class="image-box">
                                        <a href="{{ route('blog.show', $blog->slug) }}">
                                            <img src="{{ asset('storage/' . $blog->featured_image) }}" alt="{{ $blog->title }}">
                                        </a>
                                    </figure>
                                    @endif
                                    <div class="lower-content">
                                        @if($blog->category)
                                        <span class="post-category">{{ $blog->category->name }}</span>
                                        @endif
                                        <h3><a href="{{ route('blog.show', $blog->slug') }}">{{ $blog->title }}</a></h3>
                                        <p>{{ Str::limit($blog->excerpt, 100) }}</p>
                                        <div class="post-info clearfix">
                                            <div class="left-side">
                                                <span class="post-date"><i class="icon-27"></i>{{ $blog->formatted_date }}</span>
                                            </div>
                                            <div class="right-side">
                                                <a href="{{ route('blog.show', $blog->slug') }}">Read More<i class="icon-7"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12">
                            <div class="alert alert-info text-center">
                                No blog posts found{{ request('search') ? ' for "' . request('search') . '"' : '' }}.
                            </div>
                        </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    @if($blogs->hasPages())
                    <div class="pagination-wrapper centred pt-30">
                        <ul class="pagination clearfix">
                            {{-- Previous Page Link --}}
                            @if ($blogs->onFirstPage())
                                <li class="disabled"><span><i class="icon-44"></i></span></li>
                            @else
                                <li><a href="{{ $blogs->previousPageUrl() }}"><i class="icon-44"></i></a></li>
                            @endif

                            {{-- Pagination Elements --}}
                            @foreach ($blogs->getUrlRange(1, $blogs->lastPage()) as $page => $url)
                                @if ($page == $blogs->currentPage())
                                    <li><a href="{{ $url }}" class="current">{{ $page }}</a></li>
                                @else
                                    <li><a href="{{ $url }}">{{ $page }}</a></li>
                                @endif
                            @endforeach

                            {{-- Next Page Link --}}
                            @if ($blogs->hasMorePages())
                                <li><a href="{{ $blogs->nextPageUrl() }}"><i class="icon-45"></i></a></li>
                            @else
                                <li class="disabled"><span><i class="icon-45"></i></span></li>
                            @endif
                        </ul>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
