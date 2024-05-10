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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique()->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('app_id', 100)->unique()->nullable();
            $table->string('username')->nullable()->unique()->comment('Users Username');
            $table->string('type')->default('1')->comment('Users Type');
            $table->string('email')->unique()->nullable();
            $table->rememberToken();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->bigInteger('mobile_number')->nullable()->unique();
            $table->timestamp('mobile_number_verified_at')->nullable();
            $table->mediumInteger('verification_code')->nullable()->comment('OTP used for verifying the phone number');
            $table->boolean('is_twofactor')->default(false);
            $table->string('two_factor_code', 100)->nullable();
            $table->dateTime('two_factor_expires_at')->nullable();
            $table->string('registration_ip', 100)->nullable();
            $table->string('last_login_ip', 100)->nullable();
            $table->string('address')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('profile_image')->nullable();
            $table->dateTime('last_logout_at')->nullable();
            $table->dateTime('last_login_at')->nullable();
            $table->mediumText('notifications')->nullable();
            $table->foreignId('admin_role_id')->references('id')->on('admin_roles')->onDelete('cascade');
            $table->tinyInteger('is_active')->default(true)->comment('0:Inactive,1:Active')->nullable();
            $table->boolean('is_online')->default(false)->comment('0:Inactive,1:Active')->nullable();
            $table->tinyInteger('is_approve')->default(true)->comment('0:Unapproved,1:Approved')->nullable();
            $table->tinyInteger('is_blocked')->default(false)->comment('0:Unblocked,1:Blocked')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
