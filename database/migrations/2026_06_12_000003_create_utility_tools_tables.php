<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('short_urls')) {
            Schema::create('short_urls', function (Blueprint $table): void {
                $table->id();
                $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
                $table->string('title');
                $table->string('code', 32)->unique();
                $table->text('original_url');
                $table->text('description')->nullable();
                $table->unsignedBigInteger('clicks_count')->default(0);
                $table->timestamp('last_clicked_at')->nullable();
                $table->timestamp('expires_at')->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
                $table->softDeletes();
            });
        }

        if (! Schema::hasTable('qr_code_items')) {
            Schema::create('qr_code_items', function (Blueprint $table): void {
                $table->id();
                $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
                $table->string('title');
                $table->string('public_token', 64)->unique();
                $table->string('type')->default('url');
                $table->text('payload');
                $table->string('foreground_color', 7)->default('#111827');
                $table->string('background_color', 7)->default('#ffffff');
                $table->unsignedSmallInteger('size')->default(320);
                $table->unsignedBigInteger('views_count')->default(0);
                $table->timestamp('last_viewed_at')->nullable();
                $table->boolean('is_active')->default(true);
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('qr_code_items');
        Schema::dropIfExists('short_urls');
    }
};
