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
        Schema::create('assets_opening_stocks', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('project_id')->unsigned()->references('id')->on('projects')->constrained()->cascadeOnDelete();
            $table->foreignId('store_id')->unsigned()->references('id')->on('store_warehouses')->constrained()->cascadeOnDelete();
            $table->date('opeing_stock_date')->nullable();
            $table->foreignId('assets_id')->unsigned()->references('id')->on('assets')->constrained()->cascadeOnDelete();
            $table->string('quantity')->nullable();
            $table->foreignId('company_id')->unsigned()->references('id')->on('company_managments')->constrained()->cascadeOnDelete();
            $table->tinyInteger('is_active')->default(true)->comment('0:Inactive,1:Active')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets_opening_stocks');
    }
};
