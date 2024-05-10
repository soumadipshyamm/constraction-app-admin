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
        Schema::create('stock_managments', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('name')->nullable();
            $table->string('class')->nullable();
            $table->string('code')->nullable();
            $table->string('Specification')->nullable();
            $table->string('qty')->nullable();
            $table->foreignId('unit_id')->unsigned()->references('id')->on('units')->constrained()->cascadeOnDelete();
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
        Schema::dropIfExists('stock_managments');
    }
};
