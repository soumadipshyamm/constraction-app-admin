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
        Schema::create('subscription_package_options', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->foreignId('subscription_packages_id')->nullable()->references('id')->on('subscription_packages')->onDelete('cascade');
            $table->string('is_subscription')->nullable();
            $table->string('subscription_key')->nullable();
            $table->string('subscription_key_name')->nullable();
            $table->tinyInteger('is_active')->default(true)->comment('0:Inactive,1:Active')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_package_options');
    }
};
