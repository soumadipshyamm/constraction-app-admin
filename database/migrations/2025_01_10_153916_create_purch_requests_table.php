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
        Schema::create('purch_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('material_request_details_id')->nullable()->references('id')->on('material_request_details')->onDelete('cascade');
            $table->foreignId('material_requests_id')->nullable()->references('id')->on('material_requests')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->references('id')->on('company_users')->onDelete('cascade');
            $table->tinyInteger('is_active')->default(true)->comment('0:Pending,1:Approved')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purch_requests');
    }
};
