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
        Schema::create('inv_issue_goods', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('inv_issues_id')->nullable()->references('id')->on('inv_issues')->onDelete('cascade');
            $table->foreignId('materials_id')->nullable()->references('id')->on('materials')->onDelete('cascade');
            $table->string('issue_no')->nullable();
            $table->date('date')->nullable();
            $table->string('type')->nullable();
            // $table->string('issue_to')->nullable();
            $table->foreignId('inv_issue_lists_id')->nullable()->references('id')->on('inv_issue_lists')->onDelete('cascade');
            $table->string('img')->nullable();
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
        Schema::dropIfExists('inv_issue_goods');
    }
};
