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
        Schema::create('distributors', function (Blueprint $table) {
            $table->id()->from(100000);
            $table->timestamps();
            $table->enum('leg', ['LEFT', 'RIGHT']);
            $table->string('phone_number');
            $table->string('country');
            $table->decimal('wallet')->default(0);
            $table->decimal('bonus')->default(0);
            $table->string('user_id')->unique();
            $table->date('next_maintenance');
            $table->foreignId('upline_id')->constrained('uplines');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('distributors');
    }
};
