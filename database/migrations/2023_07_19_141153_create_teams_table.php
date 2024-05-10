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
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('name')->nullable();
            $table->string('designation')->nullable();
            $table->string('aadhar_no')->nullable();
            $table->string('pan_no')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('company_managments')->onDelete('cascade');
            $table->foreignId('profile_role')->unsigned()->references('id')->on('profile_designations')->constrained()->cascadeOnDelete();
            $table->foreignId('reporting_person')->unsigned()->references('id')->on('teams')->constrained()->nullable();
            $table->string('img')->nullable();
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
        Schema::dropIfExists('teams');
    }
};
// name
// designation
// aadhar_no
// pan_no
// email
// phone
// address
// role
// reporting_person
// img
