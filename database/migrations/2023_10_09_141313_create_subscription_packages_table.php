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
        Schema::create('subscription_packages', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->uniqid();
            $table->string('icon')->nullable();
            $table->string('color')->nullable();
            $table->string('title');
            $table
                ->tinyInteger('free_subscription')
                ->default(false)
                ->comment('0:Inactive,1:Active')
                ->nullable();
            $table->enum('payment_mode', ['month', 'year'])->nullable();
            $table->float('amount_inr', 8, 2)->nullable();
            $table->float('amount_usd', 8, 2)->nullable();
            $table->integer('duration')->nullable();
            $table->integer('trial_period')->nullable();
            $table->enum('interval', ['day', 'week', 'month', 'year'])->nullable();
            $table->tinyInteger('is_active')->default(true)->comment('0:Inactive,1:Active')->nullable();

            $table->timestamps();
            // $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_packages');
    }
};
