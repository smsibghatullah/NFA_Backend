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
            $table->id(); // id
            $table->string('job_title'); // job title instead of job_post_id
            $table->string('location')->nullable(); // location
            $table->date('application_deadline'); // application_deadline
            $table->unsignedInteger('number_of_positions')->default(1); // number_of_positions
            $table->string('salary_range', 50)->nullable()->comment('e.g., 50000-70000 PKR'); // salary_range
            $table->enum('required_education', ['Matric', 'Intermediate', 'Bachelors', 'Master'])->default('Matric');
            $table->string('required_experience')->default('false')->comment('Either number of months or false');
            $table->text('responsibilities')->nullable(); // responsibilities
            $table->text('additional_info')->nullable()->comment('Any extra info or instructions'); // additional_info

            // New fields

            $table->timestamps(); // created_at & updated_at
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
