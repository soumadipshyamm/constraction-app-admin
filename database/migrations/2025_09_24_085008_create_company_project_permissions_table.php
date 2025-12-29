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
        Schema::create('company_project_permissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->nullable()->constrained('projects')->onDelete('cascade');
            $table->foreignId('sub_project_id')->nullable()->constrained('sub_projects')->onDelete('cascade');
            $table->foreignId('company_id')->nullable()->constrained('company_managments')->onDelete('cascade');
            $table->foreignId('company_user_id')->nullable()->constrained('company_users')->onDelete('cascade');
            $table->foreignId('company_role_id')->nullable()->references('id')->on('company_roles')->onDelete('cascade');
            $table->foreignId('company_permission_id')->nullable()->references('id')->on('company_permissions')->onDelete('cascade');
            $table->foreignId('company_user_permission_id')->nullable()->references('id')->on('company_user_permissions')->onDelete('cascade');
            // $table->foreignId('company_user_role_id')->nullable()->references('id')->on('company_user_roles')->onDelete('cascade');
            $table->tinyInteger('is_active')->default(1)->comment('0:Inactive,1:Active')->nullable();
            $table->tinyInteger('status')->default(1)->comment('0:Inactive,1:Active')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_project_permissions');
    }
};
