<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('general_settings', function (Blueprint $table) {
            $table->id();
            $table->json('site')->nullable();
            $table->json('location')->nullable();
            $table->json('contacts')->nullable();
            $table->json('theme')->nullable();
            $table->json('email_settings')->nullable();
            $table->json('social_network')->nullable();
            $table->json('navigation')->nullable();
            $table->json('features')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('general_settings');
    }

};
