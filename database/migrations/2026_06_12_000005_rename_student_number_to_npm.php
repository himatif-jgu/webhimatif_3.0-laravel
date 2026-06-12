<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table): void {
                if (Schema::hasColumn('users', 'student_number') && ! Schema::hasColumn('users', 'npm')) {
                    $table->renameColumn('student_number', 'npm');
                }
            });
        }

        if (Schema::hasTable('attendance_records')) {
            Schema::table('attendance_records', function (Blueprint $table): void {
                if (Schema::hasColumn('attendance_records', 'student_number') && ! Schema::hasColumn('attendance_records', 'npm')) {
                    $table->renameColumn('student_number', 'npm');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('attendance_records')) {
            Schema::table('attendance_records', function (Blueprint $table): void {
                if (Schema::hasColumn('attendance_records', 'npm') && ! Schema::hasColumn('attendance_records', 'student_number')) {
                    $table->renameColumn('npm', 'student_number');
                }
            });
        }

        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table): void {
                if (Schema::hasColumn('users', 'npm') && ! Schema::hasColumn('users', 'student_number')) {
                    $table->renameColumn('npm', 'student_number');
                }
            });
        }
    }
};
