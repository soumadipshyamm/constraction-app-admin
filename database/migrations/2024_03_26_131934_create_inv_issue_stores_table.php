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
        Schema::create('inv_issue_stores', function (Blueprint $table) {
            $table->unsignedBigInteger('inv_issues_id');
            $table->unsignedBigInteger('store_warehouses_id');

            //FOREIGN KEY
            $table->foreign('inv_issues_id')->references('id')->on('inv_issues')->onDelete('cascade');
            $table->foreign('store_warehouses_id')->references('id')->on('store_warehouses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inv_issue_stores');
    }
};
