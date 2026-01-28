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
        Schema::create('job_listings', function (Blueprint $table) {
            $table->id();
            $table->string('job_title');
            $table->string('location')->nullable();
            $table->date('application_deadline');
            $table->unsignedInteger('number_of_positions')->default(1);
            $table->string('salary_range', 50)->nullable()
                  ->comment('e.g., 50000-70000 PKR');

            // ✅ ENUM removed, STRING added
            $table->string('required_education')->default('Matric');

            $table->string('required_experience')
                  ->default('false')
                  ->comment('Either number of months or false');

            $table->text('responsibilities')->nullable();
            $table->text('additional_info')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_listings');
    }
};
