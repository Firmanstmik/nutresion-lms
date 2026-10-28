<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // 4-digit school NIS, used as the student's login password. Nullable so existing
            // accounts keep logging in with their old password until an admin sets a NIS.
            if (! Schema::hasColumn('users', 'nis')) {
                $table->string('nis', 4)->nullable()->after('username');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'nis')) {
                $table->dropColumn('nis');
            }
        });
    }
};
