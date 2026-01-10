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
        Schema::create('nfa_users', function (Blueprint $table) {
              $table->id();

    $table->string('name');
    $table->string('email')->unique()->nullable();
    $table->string('cnic')->unique();          // 🔑 CNIC
    $table->string('number')->nullable();      // 📞 Phone
    $table->string('password');

    $table->boolean('is_blocked')->default(false);
    $table->timestamp('blocked_at')->nullable();

    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nfa_users');
    }
};
