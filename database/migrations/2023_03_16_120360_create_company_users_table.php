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
        Schema::create('company_users', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('name')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('password')->nullable();
            $table->string('phone')->nullable();
            $table->string('alternet_phone')->nullable();
            $table->string('address')->nullable();
            $table->string('designation')->nullable();
            $table->string('aadhar_no')->nullable();
            $table->string('pan_no')->nullable();
            // $table->string('reporting_person')->nullable();
            $table->string('dob')->nullable();
            $table->string('otp_no')->nullable();
            $table->string('otp_verify')->default('no')->nullable();
            $table->string('profile_images')->nullable();
            $table->unsignedBigInteger('company_role_id');
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('company_managments')->onDelete('cascade');
            $table->foreign('company_role_id')->references('id')->on('company_roles')->onDelete('cascade');
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
        Schema::dropIfExists('company_users');
    }
};
