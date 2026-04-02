<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tabel Meetings
        Schema::create('meetings', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('type')->nullable(); // 'rapat rutin', 'kegiatan', etc.
            $table->dateTime('meeting_date');
            $table->string('location')->nullable();
            $table->string('qr_code_token', 64)->unique();
            $table->boolean('is_active')->default(true);
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes(); // Optional: agar data aman
        });

        // 2. Tabel Pivot Meeting Attendances
        Schema::create('meeting_attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('meeting_id')->constrained('meetings')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            // Status: 'hadir', 'izin', 'absen' (alpha)
            $table->string('status')->default('absen'); 
            $table->dateTime('checkin_at')->nullable();
            $table->text('note')->nullable(); // Alasan izin, dll
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete(); // Pencatat manual
            $table->timestamps();

            // Prevent duplicate entry per user per meeting
            $table->unique(['meeting_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meeting_attendances');
        Schema::dropIfExists('meetings');
    }
};
