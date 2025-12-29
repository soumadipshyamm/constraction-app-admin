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
        Schema::create('dprs', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique()->nullable();
            $table->string('name');
            $table->date('date')->unique()->nullable();
            $table->tinyInteger('staps')->default(true)->comment('1:project,2:subproject,3:activity,4:materials,5:labour,6:assets,7:complete')->nullable();
            $table->foreignId('projects_id')->nullable()->references('id')->on('projects')->onDelete('cascade');
            $table->foreignId('sub_projects_id')->nullable()->references('id')->on('sub_projects')->onDelete('cascade');
            $table->foreignId('activities_id')->nullable()->references('id')->on('activities')->onDelete('cascade');
            $table->foreignId('assets_id')->nullable()->references('id')->on('assets')->onDelete('cascade');
            $table->foreignId('labours_id')->nullable()->references('id')->on('labours')->onDelete('cascade');
            $table->foreignId('materials_id')->nullable()->references('id')->on('materials')->onDelete('cascade');
            // $table->foreignId('safeties_id')->nullable()->references('id')->on('safeties')->onDelete('cascade');
            // $table->foreignId('hinderance_id')->nullable()->references('id')->on('hinderances')->onDelete('cascade');
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
        Schema::dropIfExists('dprs');
    }
};
