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
        Schema::create('safeties', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique()->nullable();
            $table->string('name')->nullable();
            $table->date('date')->nullable();
            $table->string('details')->nullable();
            $table->string('remarks')->nullable();
            $table->string('img')->nullable();
            $table->foreignId('company_users_id')->nullable()->references('id')->on('company_users')->onDelete('cascade');
            $table->foreignId('projects_id')->nullable()->references('id')->on('projects')->onDelete('cascade');
            $table->foreignId('sub_projects_id')->nullable()->references('id')->on('sub_projects')->onDelete('cascade');
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('company_managments')->onDelete('cascade');
            $table->foreignId('dpr_id')->nullable()->unsigned()->references('id')->on('dprs')->onDelete('cascade');
            $table->tinyInteger('is_active')->default(true)->comment('0:Inactive,1:Active')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('safeties');
    }
};
