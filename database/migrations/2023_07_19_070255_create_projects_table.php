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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('project_name')->nullable();
            $table->date('planned_start_date')->nullable();
            $table->string('address')->nullable();
            $table->date('planned_end_date')->nullable();
            $table->string('project_completed')->nullable();
            $table->date('project_completed_date')->nullable();
            $table->string('own_project_or_contractor')->nullable();
            $table->string('logo')->nullable();
            $table->string('client_company_name')->nullable();
            $table->string('client_company_address')->nullable();
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('company_managments')->onDelete('cascade');
            $table->foreignId('companies_id')->references('id')->on('companies')->onDelete('cascade');
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
        Schema::dropIfExists('projects');
    }
};


// $table->unsignedBigInteger('user_id');
// $table->unsignedBigInteger('permission_id');

// $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
// $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');