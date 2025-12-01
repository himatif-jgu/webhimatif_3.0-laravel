<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'nim')) {
                $table->renameColumn('nim', 'student_number');
            }
            if (Schema::hasColumn('users', 'angkatan')) {
                $table->renameColumn('angkatan', 'batch_year');
            }
            if (Schema::hasColumn('users', 'kelas')) {
                $table->dropColumn('kelas');
            }
            if (Schema::hasColumn('users', 'prodi')) {
                $table->dropColumn('prodi');
            }
            if (Schema::hasColumn('users', 'whatsapp_number')) {
                $table->dropColumn('whatsapp_number');
            }
            if (Schema::hasColumn('users', 'membership_status')) {
                $table->dropColumn('membership_status');
            }

            if (! Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable()->after('batch_year');
            }

            $table->string('instagram_url')->nullable()->after('phone');
            $table->string('linkedin_url')->nullable()->after('instagram_url');
            $table->string('website_url')->nullable()->after('linkedin_url');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'student_number')) {
                $table->renameColumn('student_number', 'nim');
            }
            if (Schema::hasColumn('users', 'batch_year')) {
                $table->renameColumn('batch_year', 'angkatan');
            }
            $table->dropColumn(['instagram_url', 'linkedin_url', 'website_url']);
            // columns kelas, prodi, whatsapp_number, membership_status are not restored intentionally
        });
    }
};
