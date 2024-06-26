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
        Schema::create('labour_histories', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('labours_id')->nullable()->references('id')->on('labours')->onDelete('cascade');
            $table->integer('qty')->nullable();
            $table->integer('ot_qty')->nullable();
            $table->foreignId('activities_id')->nullable()->references('id')->on('activities')->onDelete('cascade');
            $table->foreignId('vendors_id')->nullable()->references('id')->on('vendors')->onDelete('cascade');
            $table->string('rate_per_unit')->nullable();
            $table->string('remarkes')->nullable();
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('company_managments')->onDelete('cascade');
            $table->foreignId('dpr_id')->nullable()->unsigned()->references('id')->on('dprs')->onDelete('cascade');
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
        Schema::dropIfExists('labour_histories');
    }
};
