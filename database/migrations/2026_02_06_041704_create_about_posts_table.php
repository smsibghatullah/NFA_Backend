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
        Schema::create('about_posts', function (Blueprint $table) {
            $table->id();
        $table->string('title');
        $table->string('img1')->nullable();
        $table->string('img2')->nullable();
        $table->longText('content');
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_posts');
    }
};
