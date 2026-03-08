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
        Schema::table('team_documents', function (Blueprint $table) {
            $table->string('type')->default('file')->after('slot');
            $table->longText('content')->nullable()->after('file_size');
            $table->string('file_path')->nullable()->change();
            $table->string('original_name')->nullable()->change();
            $table->unsignedInteger('file_size')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('team_documents', function (Blueprint $table) {
            $table->dropColumn(['type', 'content']);
            $table->string('file_path')->nullable(false)->change();
            $table->string('original_name')->nullable(false)->change();
            $table->unsignedInteger('file_size')->nullable(false)->change();
        });
    }
};
