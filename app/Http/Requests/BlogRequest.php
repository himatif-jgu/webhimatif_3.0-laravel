<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BlogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasRole(['admin', 'bph']);
    }

    public function rules(): array
    {
        $blogId = $this->route('blog') ? $this->route('blog')->id : null;

        return [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('blogs')->ignore($blogId)],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'featured_image' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:2048'],
            'blog_category_id' => ['nullable', 'exists:blog_categories,id'],
            'author_id' => ['nullable', 'exists:users,id'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'meta_keywords' => ['nullable', 'string', 'max:255'],
            'is_published' => ['nullable', 'boolean'],
            'published_at' => ['nullable', 'date'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Blog title is required.',
            'content.required' => 'Blog content is required.',
            'featured_image.image' => 'Featured image must be an image file.',
            'featured_image.max' => 'Featured image size must not exceed 2MB.',
            'blog_category_id.exists' => 'Selected category is invalid.',
        ];
    }
}
