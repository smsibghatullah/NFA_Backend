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
        Schema::create('candidates', function (Blueprint $table) {
            $table->id();
            $table->integer('sr_no');
        $table->string('roll_no');
        $table->string('name');
        $table->string('father_name');
        $table->string('cnic');
        $table->text('post_applied_for');
        $table->text('postal_address');
        $table->string('mobile_no');
        $table->string('paper');
        $table->string('test_date');
        $table->string('session');
        $table->string('reporting_time');
        $table->string('conduct_time');
        $table->string('venue');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidates');
    }
};
