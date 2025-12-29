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
        Schema::create('admin_user_role_permissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role_id')->references('id')->on('admin_roles')->onDelete('cascade');
            $table->foreignId('menu_id')->references('id')->on('admin_menus')->onDelete('cascade');
            $table->string('action');
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_user_role_permissions');
    }
};
