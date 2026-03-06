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
        Schema::create('commits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('repository_id')->constrained()->cascadeOnDelete();
            $table->string('sha', 40);
            $table->text('message');
            $table->string('author_name');
            $table->string('author_email');
            $table->string('author_login')->nullable();
            $table->timestamp('committed_at');
            $table->string('url');
            $table->timestamps();

            $table->unique(['repository_id', 'sha']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commits');
    }
};
