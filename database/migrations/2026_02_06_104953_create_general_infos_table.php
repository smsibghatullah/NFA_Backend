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
        Schema::create('general_infos', function (Blueprint $table) {
              $table->id();
        $table->string('email');
        $table->string('phone');
        $table->string('address');

        // Social links (nullable)
        $table->string('facebook')->nullable();
        $table->string('twitter')->nullable();
        $table->string('instagram')->nullable();

        // visibility
        $table->boolean('is_visible')->default(1);

        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('general_infos');
    }
};
