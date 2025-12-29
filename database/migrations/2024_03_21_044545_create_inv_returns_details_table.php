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
        Schema::create('inv_returns_details', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('inv_return_goods_id')->nullable()->references('id')->on('inv_return_goods')->onDelete('cascade');
            $table->foreignId('materials_id')->nullable()->references('id')->on('materials')->onDelete('cascade');
            $table->foreignId('activities_id')->nullable()->references('id')->on('activities')->onDelete('cascade');
            $table->string('return_qty')->nullable();
            $table->integer('stock_qty')->nullable();
            $table->string('remarkes')->nullable();
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('company_managments')->onDelete('cascade');
            $table->tinyInteger('is_active')->default(true)->comment('0:Inactive,1:Active')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inv_returns_details');
    }
};
