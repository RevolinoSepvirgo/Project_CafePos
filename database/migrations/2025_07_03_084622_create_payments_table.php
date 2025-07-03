<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('revo_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('revo_orders')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // kasir
            $table->string('method'); // Tunai, QRIS, Debit
            $table->integer('amount'); // Jumlah dibayar
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('revo_payments');
    }
};
