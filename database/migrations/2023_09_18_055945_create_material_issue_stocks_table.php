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
        Schema::create('material_issue_stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->nullable()->references('id')->on('projects')->cascadeOnDelete();
            $table->foreignId('store_id')->nullable()->references('id')->on('store_warehouses')->cascadeOnDelete();
            $table->foreignId('material_id')->nullable()->references('id')->on('materials')->cascadeOnDelete();

            $table->string('in_stock')->nullable();
            $table->string('add_stock')->nullable();
            $table->string('less_stock')->nullable();
            $table->string('code')->nullable();
            $table->string('total_qty')->nullable();


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
        Schema::dropIfExists('material_issue_stocks');
    }
};
