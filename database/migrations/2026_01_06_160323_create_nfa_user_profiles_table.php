<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /**
         * ============================
         * USER PROFILES
         * ============================
         */
        Schema::create('nfa_user_profiles', function (Blueprint $table) {
            $table->id();

            $table->foreignId('nfa_user_id')
                ->constrained('nfa_users')
                ->cascadeOnDelete();

            // 🔹 Mandatory Personal Info
            $table->string('father_name');
            $table->string('cnic')->unique();
            $table->enum('gender', ['male', 'female', 'other']);
            $table->enum('marital_status', ['single', 'married']);

            $table->date('date_of_birth');
            $table->string('phone_number');

            // 🔹 Addresses
            $table->string('permanent_address');
            $table->string('current_address');
            $table->string('postal_code');

            // 🔹 Domicile & Identity
            $table->string('domicile_city');
            $table->string('domicile_province');
            $table->string('religion');
            $table->string('nationality');

            // 🔹 Occupation
            $table->enum('current_occupation', [
                'government',
                'private',
                'unemployed'
            ]);

            // 🔹 Optional
            $table->string('profile_picture')->nullable();
            $table->text('bio')->nullable();

            $table->timestamps();
        });

        /**
         * ============================
         * USER EDUCATIONS
         * ============================
         */
        Schema::create('nfa_user_educations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('profile_id')
                ->constrained('nfa_user_profiles')
                ->cascadeOnDelete();

            $table->string('institution_name');
            $table->string('degree');
            $table->string('field_of_study');

            $table->date('start_date');
            $table->date('end_date')->nullable();

            $table->string('grade')->nullable();
            $table->text('description')->nullable();

            $table->timestamps();
        });

        /**
         * ============================
         * USER WORK HISTORIES
         * ============================
         */
        Schema::create('nfa_user_work_histories', function (Blueprint $table) {
            $table->id();

            $table->foreignId('profile_id')
                ->constrained('nfa_user_profiles')
                ->cascadeOnDelete();

            $table->string('company_name');
            $table->string('job_title');

            $table->date('start_date');
            $table->date('end_date')->nullable();

            $table->boolean('is_current')->default(false);
            $table->text('responsibilities')->nullable();

            $table->timestamps();
        });

        /**
         * ============================
         * USER SKILLS
         * ============================
         */
        Schema::create('nfa_user_skills', function (Blueprint $table) {
            $table->id();

            $table->foreignId('profile_id')
                ->constrained('nfa_user_profiles')
                ->cascadeOnDelete();

            $table->string('name');
            $table->string('description')->nullable();

            $table->timestamps();
        });

        /**
         * ============================
         * USER HOBBIES
         * ============================
         */
        Schema::create('nfa_user_hobbies', function (Blueprint $table) {
            $table->id();

            $table->foreignId('profile_id')
                ->constrained('nfa_user_profiles')
                ->cascadeOnDelete();

            $table->string('name');
            $table->string('description')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nfa_user_hobbies');
        Schema::dropIfExists('nfa_user_skills');
        Schema::dropIfExists('nfa_user_work_histories');
        Schema::dropIfExists('nfa_user_educations');
        Schema::dropIfExists('nfa_user_profiles');
    }
};
