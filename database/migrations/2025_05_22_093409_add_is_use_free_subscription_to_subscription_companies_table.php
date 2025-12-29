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
        Schema::table('subscription_companies', function (Blueprint $table) {
            $table->enum('is_use_free_subscription', ['0', '1'])->default('0')->comment('0:not use free subscription, 1:use free subscription');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subscription_companies', function (Blueprint $table) {
        });
    }
};
