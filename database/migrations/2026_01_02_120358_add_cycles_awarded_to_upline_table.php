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
        Schema::table('uplines', function (Blueprint $table) {
            $table->smallInteger('cycles_awarded');
            $table->timestamp('cycles_awarded_date')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('uplines', function (Blueprint $table) {
            $table->dropColumn('cycles_awarded');
            $table->dropColumn('cycles_awarded_date');
        });
    }
};
