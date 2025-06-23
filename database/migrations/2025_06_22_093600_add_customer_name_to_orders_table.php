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
    Schema::table('revo_orders', function (Blueprint $table) {
        $table->string('customer_name')->nullable()->after('user_id');
    });
}

public function down()
{
    Schema::table('revo_orders', function (Blueprint $table) {
        $table->dropColumn('customer_name');
    });
}

};
