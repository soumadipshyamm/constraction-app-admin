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
        Schema::create('company_user_roles', function (Blueprint $table) {
            $table->unsignedBigInteger('company_user_id');
            $table->unsignedBigInteger('company_role_id');
           

         //FOREIGN KEY
           $table->foreign('company_user_id')->references('id')->on('company_users')->onDelete('cascade');
           $table->foreign('company_role_id')->references('id')->on('company_roles')->onDelete('cascade');

         //PRIMARY KEYS
           $table->primary(['company_user_id','company_role_id']);

           $table->engine = 'InnoDB';
           $table->charset = 'utf8';
           $table->collation = 'utf8_unicode_ci';
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_user_roles');
    }
};