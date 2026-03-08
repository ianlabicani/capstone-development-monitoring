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
        Schema::table('user_stories', function (Blueprint $table) {
            if (! Schema::hasColumn('user_stories', 'manually_achieved_at')) {
                $table->timestamp('manually_achieved_at')->nullable()->after('is_achieved');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_stories', function (Blueprint $table) {
            $table->dropColumn('manually_achieved_at');
        });
    }
};
