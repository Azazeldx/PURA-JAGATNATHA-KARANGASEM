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
        Schema::table('posts', function (Blueprint $table) {
            $table->foreignId('cover_id')->after('id')->nullable()->constrained('curator')->cascadeOnUpdate()->nullOnDelete();
            $table->json('content')->after('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('content');
            $table->dropForeign(['cover_id']);
            $table->dropColumn('cover_id');
        });
    }
};
