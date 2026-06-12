<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('landing_contents', function (Blueprint $table): void {
            $table->id();
            $table->string('section');
            $table->string('key')->unique();
            $table->string('eyebrow')->nullable();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->longText('body')->nullable();
            $table->string('image_path')->nullable();
            $table->string('button_label')->nullable();
            $table->string('button_url')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamp('published_at')->nullable();
            $table->json('settings')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['section', 'is_active', 'sort_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('landing_contents');
    }
};
