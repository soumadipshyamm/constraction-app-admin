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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('payment_status')->nullable();
            $table->string('payment_amount')->nullable();
            $table->string('payment_date')->nullable();
            $table->string('subscription_type')->nullable();
            $table->foreignId('subscription_package_id')->nullable()->references('id')->on('subscription_packages')->onDelete('cascade');
            $table->foreignId('subscription_companie_id')->nullable()->references('id')->on('subscription_companies')->onDelete('cascade');
            $table->foreignId('company_id')->nullable()->references('id')->on('company_managments')->onDelete('cascade');
            $table->foreignId('company_user_id')->nullable()->references('id')->on('company_users')->onDelete('cascade');
            $table->json('payment_data')->nullable();
            $table->tinyInteger('is_active')->default(true)->comment('0:Inactive,1:Active')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
