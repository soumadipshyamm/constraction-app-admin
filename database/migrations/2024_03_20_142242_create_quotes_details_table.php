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
        Schema::create('quotes_details', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('quotes_id')->nullable()->references('id')->on('quotes')->onDelete('cascade');
            $table->foreignId('materials_id')->nullable()->references('id')->on('materials')->onDelete('cascade');
            $table->foreignId('material_request_details_id')->nullable()->references('id')->on('material_request_details')->onDelete('cascade');
            $table->foreignId('material_requests_id')->nullable()->references('id')->on('material_requests')->onDelete('cascade');
            $table->string('request_no')->nullable();
            $table->string('qty')->nullable();
            $table->string('request_qty')->nullable();
            $table->string('price')->nullable();
            $table->date('date')->nullable();
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
        Schema::dropIfExists('quotes_details');
    }
};
