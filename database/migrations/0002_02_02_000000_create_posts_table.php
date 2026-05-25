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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->string('status', 20)->index();
            $table->json('card_content');
            $table->json('page_content');
            $table->json('metadata');
            $table->foreignId('post_type_id')->nullable()->constrained('post_types')->cascadeOnUpdate()->nullOnDelete();
            $table->foreignId('author_id')->nullable()->constrained('users')->cascadeOnUpdate()->nullOnDelete();
            $table->dateTime('highlighted_at')->nullable();
            $table->dateTime('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['slug', 'post_type_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
