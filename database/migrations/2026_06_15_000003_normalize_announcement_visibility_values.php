<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('announcements')
            ->where('visibility', 'internal')
            ->update(['visibility' => 'dashboard_only']);
    }

    public function down(): void
    {
        //
    }
};
