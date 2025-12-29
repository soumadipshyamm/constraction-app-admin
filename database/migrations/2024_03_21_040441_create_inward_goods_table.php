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
        Schema::create('inward_goods', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('inv_inwards_id')->nullable()->references('id')->on('inv_inwards')->onDelete('cascade');
            $table->foreignId('materials_id')->nullable()->references('id')->on('materials')->onDelete('cascade');
            $table->string('grn_no')->nullable();
            $table->date('date')->nullable();
            // $table->string('type')->nullable();
            $table->foreignId('inv_inward_entry_types_id')->nullable()->references('id')->on('inv_inward_entry_types')->onDelete('cascade');
            $table->string('delivery_ref_copy_no')->nullable();
            $table->date('delivery_ref_copy_date')->nullable();
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
        Schema::dropIfExists('inward_goods');
    }
};
