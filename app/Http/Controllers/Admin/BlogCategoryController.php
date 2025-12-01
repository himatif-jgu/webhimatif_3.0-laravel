<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogCategoryRequest;
use App\Models\BlogCategory;
use Illuminate\Http\Request;

class BlogCategoryController extends Controller
{
    public function index()
    {
        $categories = BlogCategory::withCount('blogs')
            ->latest('created_at')
            ->paginate(15);

        return view('admin.blog_category.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.blog_category.create');
    }

    public function store(BlogCategoryRequest $request)
    {
        $validated = $request->validated();
        BlogCategory::create($validated);

        return redirect()->route('admin.blog-categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function edit(BlogCategory $blogCategory)
    {
        return view('admin.blog_category.edit', compact('blogCategory'));
    }

    public function update(BlogCategoryRequest $request, BlogCategory $blogCategory)
    {
        $validated = $request->validated();
        $blogCategory->update($validated);

        return redirect()->route('admin.blog-categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(BlogCategory $blogCategory)
    {
        if ($blogCategory->blogs()->count() > 0) {
            return redirect()->route('admin.blog-categories.index')
                ->with('error', 'Cannot delete category with existing blog posts.');
        }

        $blogCategory->delete();

        return redirect()->route('admin.blog-categories.index')
            ->with('success', 'Category deleted successfully.');
    }
}
