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
        Schema::create('additional_features', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('aditional_project_inr')->nullable();
            $table->string('aditional_project_usd')->nullable();
            $table->string('additional_users_inr')->nullable();
            $table->string('additional_users_usd')->nullable();
            $table->tinyInteger('is_active')->default(true)->comment('0:Inactive,1:Active')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('additional_features');
    }
};
