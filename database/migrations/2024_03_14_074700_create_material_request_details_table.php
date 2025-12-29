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
        Schema::create('material_request_details', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique()->nullable();
            $table->foreignId('projects_id')->nullable()->references('id')->on('projects')->onDelete('cascade');
            $table->foreignId('sub_projects_id')->nullable()->references('id')->on('sub_projects')->onDelete('cascade');
            $table->foreignId('materials_id')->nullable()->references('id')->on('materials')->onDelete('cascade');
            // $table->foreignId('materialopening_id')->nullable()->references('id')->on('material_opening_stocks')->onDelete('cascade');
            $table->foreignId('material_requests_id')->nullable()->references('id')->on('material_requests')->onDelete('cascade');
            $table->foreignId('activities_id')->nullable()->references('id')->on('activities')->onDelete('cascade');
            $table->date('date')->nullable();
            $table->integer('qty')->nullable();
            $table->string('remarks')->nullable();
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
        Schema::dropIfExists('material_request_details');
    }
};
