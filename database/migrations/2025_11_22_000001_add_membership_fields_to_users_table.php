<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->unique()->nullable()->after('name');
            $table->string('nim')->unique()->nullable()->after('username');
            $table->unsignedSmallInteger('angkatan')->nullable()->after('nim');
            $table->string('kelas')->nullable()->after('angkatan');
            $table->string('prodi')->default('Teknik Informatika')->after('kelas');
            $table->string('phone')->nullable()->after('prodi');
            $table->string('whatsapp_number')->nullable()->after('phone');
            $table->string('membership_status')->default('non_member')->after('whatsapp_number');
            $table->boolean('is_active')->default(true)->after('membership_status');
            $table->string('avatar')->nullable()->after('is_active');
            $table->string('gender')->nullable()->after('avatar');
            $table->date('birth_date')->nullable()->after('gender');
            $table->text('address')->nullable()->after('birth_date');
            $table->text('bio')->nullable()->after('address');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropColumn([
                'username',
                'nim',
                'angkatan',
                'kelas',
                'prodi',
                'phone',
                'whatsapp_number',
                'membership_status',
                'is_active',
                'avatar',
                'gender',
                'birth_date',
                'address',
                'bio',
            ]);
        });
    }
};
