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
        Schema::create('subscription_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('is_subscribed')->nullable()->references('id')->on('subscription_packages')->onDelete('cascade');
            $table->foreignId('company_id')->nullable()->references('id')->on('company_managments')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->references('id')->on('company_users')->onDelete('cascade');
            $table->foreignId('additional_feature_id')->nullable()->references('id')->on('additional_features')->onDelete('cascade');
            $table->date('from_date')->nullable();
            $table->date('to_date')->nullable();
            $table->string('type')->nullable();
            $table->tinyInteger('status')->default(true)->comment('0:Inactive,1:Active,3:upcomming')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_logs');
    }
};
