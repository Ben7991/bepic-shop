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
        Schema::create('bonus_withdrawals', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->decimal("amount");
            $table->foreignId("distributor_id")->constrained("distributors");
            $table->decimal("deduction");
            $table->enum("status", ["PENDING", "APPROVED"]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bonus_withdrawals');
    }
};
