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
        Schema::create('inventory_logs', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique()->nullable();
            $table->foreignId('projects_id')->nullable()->references('id')->on('projects')->onDelete('cascade');
            $table->foreignId('store_warehouses_id')->nullable()->references('id')->on('store_warehouses')->onDelete('cascade');
            $table->foreignId('materials_id')->nullable()->references('id')->on('materials')->onDelete('cascade');
            $table->foreignId('assets_id')->nullable()->references('id')->on('assets')->onDelete('cascade')->after('remarkes');
            $table->foreignId('activities_id')->nullable()->references('id')->on('activities')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->references('id')->on('company_users')->onDelete('cascade');
            $table->date('date')->nullable();
            $table->string('type')->nullable();
            $table->integer('qty')->nullable();
            $table->string('remarks')->nullable();
            $table->string('recipt_qty')->nullable();
            $table->integer('reject_qty')->nullable();
            $table->integer('total_qty')->nullable();
            $table->decimal('price', 9, 3)->nullable();
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
        Schema::dropIfExists('inventory_logs');
    }
};
