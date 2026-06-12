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
            $table->string('npm')->unique()->nullable()->after('username');
            $table->unsignedSmallInteger('batch_year')->nullable()->after('npm');
            $table->string('phone')->nullable()->after('batch_year');
            $table->boolean('is_active')->default(true)->after('phone');
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
                'npm',
                'batch_year',
                'phone',
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
