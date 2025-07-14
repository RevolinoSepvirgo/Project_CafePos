<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyUserIdOnRevoOrders extends Migration
{
    public function up()
    {
        Schema::table('revo_orders', function (Blueprint $table) {
            // Hapus foreign key lama dulu
            $table->dropForeign(['user_id']);

            // Ubah user_id jadi nullable dan set null saat user dihapus
            $table->unsignedBigInteger('user_id')->nullable()->change();

            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('revo_orders', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->unsignedBigInteger('user_id')->nullable(false)->change();

            $table->foreign('user_id')
                  ->references('id')->on('users')
                  ->onDelete('restrict');
        });
    }
}
