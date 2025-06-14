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
        Schema::create('uplines', function (Blueprint $table) {
            $table->id()->from(100000);
            $table->timestamps();
            $table->integer('left_leg')->default(0);
            $table->integer('right_leg')->default(0);
            $table->string('user_id')->unique();
            $table->integer('left_leg_count')->default(0);
            $table->integer('right_leg_count')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uplines');
    }
};
