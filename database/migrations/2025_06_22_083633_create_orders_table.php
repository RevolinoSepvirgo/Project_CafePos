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
        Schema::create('revo_orders', function (Blueprint $table) {
                $table->id();
                $table->foreignId('table_id')->constrained('revo_tables');
                $table->foreignId('user_id')->constrained('users');
                $table->enum('status', ['menunggu', 'dibayar', 'batal'])->default('menunggu');
                $table->timestamps();
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
