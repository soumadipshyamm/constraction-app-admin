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
        Schema::create('inventory_stores', function (Blueprint $table) {
            $table->foreignId('inventories_id')->nullable()->references('id')->on('inventories')->onDelete('cascade');
            $table->foreignId('store_warehouses_id')->nullable()->references('id')->on('store_warehouses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_stores');
    }
};
