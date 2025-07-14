<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserNameToRevoOrdersTable extends Migration
{
    public function up()
    {
        Schema::table('revo_orders', function (Blueprint $table) {
            $table->string('user_name')->nullable()->after('user_id');
        });
    }

    public function down()
    {
        Schema::table('revo_orders', function (Blueprint $table) {
            $table->dropColumn('user_name');
        });
    }
}
