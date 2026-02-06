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
        Schema::create('forensic_posts', function (Blueprint $table) {
            $table->id();
    $table->string('tab'); // e.g., tab-1, tab-2
    $table->string('title');
    $table->string('img1')->nullable();
    $table->string('img2')->nullable();
    $table->longText('content'); // HTML content
    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('forensic_posts');
    }
};
