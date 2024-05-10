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
        Schema::create('materials_stock_reports', function (Blueprint $table) {
            $table->id();
            $table->string('instock')->nullable();
            $table->string('addstock')->nullable();
            $table->string('lessstock')->nullable();
            $table->string('code')->nullable();
            $table->foreignId('material_id')->references('id')->on('materials')->cascadeOnDelete();
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('company_managments')->onDelete('cascade');
            $table->string('action')->nullable();
            $table->string('report')->nullable();
            $table->string('type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materials_stock_reports');
    }
};
