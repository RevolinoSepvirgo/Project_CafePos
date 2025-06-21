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
        Schema::table('revo_tables', function (Blueprint $table) {
             $table->enum('status', ['kosong', 'dipesan', 'terisi'])->default('kosong')->after('name');
            $table->integer('capacity')->default(4)->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('revo_tables', function (Blueprint $table) {
            $table->dropColumn(['status', 'capacity']);

        });
    }
};
