<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;

class LandingPageBlogController extends Controller
{
    public function index(Request $request)
    {
        $query = Blog::with(['category', 'author'])
            ->published()
            ->latest();

        if ($request->has('category') && $request->category) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->has('search') && $request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('excerpt', 'like', '%' . $request->search . '%')
                    ->orWhere('content', 'like', '%' . $request->search . '%');
            });
        }

        $blogs = $query->paginate(9);
        $categories = BlogCategory::where('is_active', true)
            ->withCount(['activeBlogs'])
            ->having('active_blogs_count', '>', 0)
            ->get();
        $recentPosts = Blog::published()
            ->latest()
            ->limit(3)
            ->get();

        return view('landingpage.blog.index', compact('blogs', 'categories', 'recentPosts'));
    }

    public function show($slug)
    {
        $blog = Blog::with(['category', 'author'])
            ->where('slug', $slug)
            ->published()
            ->firstOrFail();

        $blog->incrementViews();

        $relatedBlogs = Blog::published()
            ->where('id', '!=', $blog->id)
            ->where('blog_category_id', $blog->blog_category_id)
            ->latest()
            ->limit(3)
            ->get();

        $categories = BlogCategory::where('is_active', true)
            ->withCount(['activeBlogs'])
            ->having('active_blogs_count', '>', 0)
            ->get();

        $recentPosts = Blog::published()
            ->latest()
            ->limit(3)
            ->get();

        return view('landingpage.blog.show', compact('blog', 'relatedBlogs', 'categories', 'recentPosts'));
    }
}
