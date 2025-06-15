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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('distributor_id')->constrained('distributors');
            $table->foreignId('product_id')->constrained('products');
            $table->smallInteger('quantity');
            $table->enum('purchase_type', ['MAINTENANCE', 'REORDER']);
            $table->enum('status', ['PENDING', 'APPROVED'])->default('PENDING');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
