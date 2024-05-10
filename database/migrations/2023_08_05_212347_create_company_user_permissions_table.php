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
        Schema::create('company_user_permissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_user_id');
            $table->unsignedBigInteger('company_permission_id');

            $table->foreign('company_user_id')->references('id')->on('company_users')->onDelete('cascade');
            $table->foreign('company_permission_id')->references('id')->on('company_permissions')->onDelete('cascade');
            $table->string('action');

            // $table->primary(['company_user_id','company_permission_id']);

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
        Schema::dropIfExists('company_user_permissions');
    }
};
