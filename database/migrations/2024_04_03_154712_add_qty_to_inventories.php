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
        Schema::table('inventories', function (Blueprint $table) {
            $table->foreignId('assets_id')->nullable()->references('id')->on('assets')->onDelete('cascade')->after('remarkes');
            $table->string('recipt_qty')->nullable();
            $table->integer('reject_qty')->nullable();
            $table->integer('total_qty')->nullable();
            $table->decimal('price', 9, 3)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inventories', function (Blueprint $table) {
            //
        });
    }
};
