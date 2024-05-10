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
        Schema::create('company_role_permissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_role_id');
            $table->unsignedBigInteger('company_permission_id');

            //FOREIGN KEY
            $table->foreign('company_role_id')->references('id')->on('company_roles')->onDelete('cascade');
            $table->foreign('company_permission_id')->references('id')->on('company_permissions')->onDelete('cascade');
            $table->string('action');

            //PRIMARY KEYS
            // $table->primary(['company_role_id', 'company_permission_id']);
            // $table->engine = 'InnoDB';
            // $table->charset = 'utf8';
            // $table->collation = 'utf8_unicode_ci';
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_role_permissions');
    }
};
