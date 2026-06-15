<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('announcements', function (Blueprint $table): void {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('summary', 500)->nullable();
            $table->longText('content');
            $table->string('category')->default('general');
            $table->string('visibility')->default('public');
            $table->string('audience')->default('all');
            $table->boolean('is_pinned')->default(false);
            $table->boolean('is_published')->default(false);
            $table->dateTime('published_at')->nullable();
            $table->dateTime('expires_at')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['is_published', 'visibility', 'published_at', 'expires_at'], 'announcements_publish_visibility_idx');
            $table->index(['is_pinned', 'published_at'], 'announcements_pinned_published_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
