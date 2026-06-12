<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('attendance_events')) {
            Schema::create('attendance_events', function (Blueprint $table): void {
                $table->id();
                $table->string('title');
                $table->string('activity_type')->default('meeting');
                $table->text('description')->nullable();
                $table->string('location')->nullable();
                $table->dateTime('starts_at');
                $table->dateTime('ends_at')->nullable();
                $table->dateTime('check_in_opens_at')->nullable();
                $table->dateTime('check_in_closes_at')->nullable();
                $table->string('qr_token')->unique();
                $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
                $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete();
                $table->boolean('is_active')->default(true);
                $table->timestamps();

                $table->index(['activity_type', 'starts_at'], 'attendance_events_type_starts_idx');
                $table->index(['is_active', 'check_in_opens_at', 'check_in_closes_at'], 'attendance_events_window_idx');
            });
        }

        if (! Schema::hasTable('attendance_records')) {
            Schema::create('attendance_records', function (Blueprint $table): void {
                $table->id();
                $table->foreignId('attendance_event_id')->constrained()->cascadeOnDelete();
                $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
                $table->string('npm');
                $table->string('attendee_name')->nullable();
                $table->string('status')->default('present');
                $table->string('source')->default('manual');
                $table->dateTime('checked_in_at')->nullable();
                $table->foreignId('checked_in_by')->nullable()->constrained('users')->nullOnDelete();
                $table->text('notes')->nullable();
                $table->timestamps();

                $table->unique(['attendance_event_id', 'npm'], 'attendance_records_event_npm_unique');
                $table->index(['status', 'checked_in_at'], 'attendance_records_status_checked_idx');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('attendance_records');
        Schema::dropIfExists('attendance_events');
    }
};
