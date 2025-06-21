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
    Schema::disableForeignKeyConstraints();

    Schema::rename('tables','revo_tables');
    Schema::rename('orders','revo_orders');
    Schema::rename('order_items','revo_order_items');
    Schema::rename('menus','revo_menus');
    Schema::rename('categories','revo_categories');

    Schema::enableForeignKeyConstraints();
}

public function down(): void
{
    Schema::disableForeignKeyConstraints();

    Schema::rename('revo_tables','tables');
    Schema::rename('revo_orders','orders');
    Schema::rename('revo_order_items','order_items');
    Schema::rename('revo_menus','menus');
    Schema::rename('revo_categories','categories');

    Schema::enableForeignKeyConstraints();
}

};
