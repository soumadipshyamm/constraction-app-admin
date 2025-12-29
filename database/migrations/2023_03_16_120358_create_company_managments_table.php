<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('company_managments', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('name')->nullable();
            $table->string('registration_no')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('website_link')->nullable();
            $table->string('country')->nullable();
            $table->string('country_name')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('profile_images')->nullable();
            // $table->foreignId('is_subscribed')->nullable()->references('id')->on('subscription_packages')->onDelete('cascade');
            // $table->tinyInteger('is_subscribed')->default(false)->comment('0:paid,1:free')->nullable();
            $table
                ->tinyInteger('is_active')
                ->default(true)
                ->comment('0:Inactive,1:Active')
                ->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_managments');
    }
};
