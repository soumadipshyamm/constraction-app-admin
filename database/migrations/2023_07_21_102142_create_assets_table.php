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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            // $table->foreignId('project_id')->nullable()->references('id')->on('projects');
            // $table->foreignId('store_warehouses_id')->nullable()->references('id')->on('store_warehouses');
            $table->string('name')->nullable();
            $table->string('code')->nullable();
            $table->string('specification')->nullable();
            $table->foreignId('unit_id')->unsigned()->references('id')->on('units')->constrained()->cascadeOnDelete();
            $table->string('quantity')->nullable();
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
        Schema::dropIfExists('assets');
    }
};
