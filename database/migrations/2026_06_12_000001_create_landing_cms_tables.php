<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('history_entries', function (Blueprint $table): void {
            $table->id();
            $table->string('type')->default('journey');
            $table->string('title');
            $table->string('period')->nullable();
            $table->longText('body')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('foundation_contents', function (Blueprint $table): void {
            $table->id();
            $table->string('type')->default('vision');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('summary')->nullable();
            $table->longText('body')->nullable();
            $table->string('image_path')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('team_units', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('subtitle')->nullable();
            $table->longText('description')->nullable();
            $table->string('icon')->default('users');
            $table->string('image_path')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('leadership_members', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('position');
            $table->string('department')->nullable();
            $table->string('photo_path')->nullable();
            $table->string('profile_url')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('contact_information', function (Blueprint $table): void {
            $table->id();
            $table->string('label');
            $table->string('type')->default('text');
            $table->text('value');
            $table->string('url')->nullable();
            $table->string('icon_path')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_information');
        Schema::dropIfExists('leadership_members');
        Schema::dropIfExists('team_units');
        Schema::dropIfExists('foundation_contents');
        Schema::dropIfExists('history_entries');
    }
};
