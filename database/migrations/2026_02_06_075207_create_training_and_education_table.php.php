<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('training_and_education', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('img1')->nullable();
            $table->string('img2')->nullable();
            $table->longText('content');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('training_and_education');
    }
};
