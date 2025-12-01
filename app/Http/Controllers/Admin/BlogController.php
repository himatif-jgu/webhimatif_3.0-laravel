<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogRequest;
use App\Models\Blog;
use App\Models\BlogCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::with(['category', 'author'])
            ->latest('created_at')
            ->paginate(15);

        return view('admin.blog.index', compact('blogs'));
    }

    public function create()
    {
        $categories = BlogCategory::where('is_active', true)->get();
        return view('admin.blog.create', compact('categories'));
    }

    public function store(BlogRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $this->uploadImage($request->file('featured_image'));
        }

        if ($request->has('is_published') && $request->is_published) {
            $validated['published_at'] = $validated['published_at'] ?? now();
        }

        $blog = Blog::create($validated);

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog post created successfully.');
    }

    public function edit(Blog $blog)
    {
        $categories = BlogCategory::where('is_active', true)->get();
        return view('admin.blog.edit', compact('blog', 'categories'));
    }

    public function update(BlogRequest $request, Blog $blog)
    {
        $validated = $request->validated();

        if ($request->hasFile('featured_image')) {
            if ($blog->featured_image && Storage::disk('public')->exists($blog->featured_image)) {
                Storage::disk('public')->delete($blog->featured_image);
            }
            $validated['featured_image'] = $this->uploadImage($request->file('featured_image'));
        }

        if ($request->has('is_published') && $request->is_published && !$blog->is_published) {
            $validated['published_at'] = $validated['published_at'] ?? now();
        } elseif (!$request->has('is_published') || !$request->is_published) {
            $validated['published_at'] = null;
        }

        $blog->update($validated);

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog post updated successfully.');
    }

    public function destroy(Blog $blog)
    {
        if ($blog->featured_image && Storage::disk('public')->exists($blog->featured_image)) {
            Storage::disk('public')->delete($blog->featured_image);
        }

        $blog->delete();

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog post deleted successfully.');
    }

    private function uploadImage($file)
    {
        $folderName = "blogs/" . Carbon::now()->format('Y/m');
        return $file->store($folderName, 'public');
    }
}
