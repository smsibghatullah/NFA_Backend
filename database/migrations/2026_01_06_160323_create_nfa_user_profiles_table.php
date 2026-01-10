<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nfa_user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nfa_user_id')->constrained('nfa_users')->onDelete('cascade');

            $table->date('date_of_birth')->nullable();
            $table->string('postal_address')->nullable();
            $table->string('phone_number')->nullable();
            $table->text('bio')->nullable();

            $table->timestamps();
        });

        // Optional: separate tables for educations and work_histories
        Schema::create('nfa_user_educations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained('nfa_user_profiles')->onDelete('cascade');
            $table->string('institution_name');
            $table->string('degree');
            $table->string('field_of_study');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->string('grade')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('nfa_user_work_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained('nfa_user_profiles')->onDelete('cascade');
            $table->string('company_name');
            $table->string('job_title');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->text('responsibilities')->nullable();
            $table->boolean('is_current')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nfa_user_work_histories');
        Schema::dropIfExists('nfa_user_educations');
        Schema::dropIfExists('nfa_user_profiles');
    }
};
