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
        Schema::create('materials_stock_management', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('class')->nullable();
            $table->string('code')->unique();
            $table->string('qty')->nullable();
            $table->date('opeing_stock_date')->nullable();
            $table->foreignId('project_id')->unsigned()->references('id')->on('projects')->constrained()->cascadeOnDelete();
            $table->foreignId('store_id')->unsigned()->references('id')->on('store_warehouses')->constrained()->cascadeOnDelete();
            $table->foreignId('unit_id')->unsigned()->references('id')->on('units')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('company_managments')->onDelete('cascade');
            $table->tinyInteger('is_active')->default(true)->comment('0:Inactive,1:Active')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materials_stock_management');
    }
};
