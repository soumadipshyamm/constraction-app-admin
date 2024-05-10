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
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('parent_id')->nullable()->references('id')->on('activities');
            $table->string('sl_no')->nullable();
            $table->foreignId('project_id')->nullable()->references('id')->on('projects');
            $table->foreignId('subproject_id')->nullable()->references('id')->on('sub_projects');
            $table->string('type')->nullable();
            $table->string('activities')->nullable();
            $table->foreignId('unit_id')->nullable()->references('id')->on('units')->cascadeOnDelete();
            $table->string('qty')->nullable();
            $table->string('rate')->nullable();
            $table->string('amount')->nullable();
            $table->string('start_date')->nullable();
            $table->string('end_date')->nullable();
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
        Schema::dropIfExists('activities');
    }
};