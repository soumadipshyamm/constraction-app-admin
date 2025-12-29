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
            $table->string('details')->nullable();
            $table->date('trial_start')->nullable();
            $table->date('trial_end')->nullable();
            $table->integer('trial_day')->nullable();
            $table->tinyInteger('is_trial')->default(true)->comment('0:Inactive,1:Active')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subscription_companies', function (Blueprint $table) {
            //
        });
    }
};

// Mobile App Access: Yes
// Web App Access: No
// Purchase Orders (PO): No
// Approvals: No
// Inward Multiple Option: No
// Subproject Creation: No
// Multistores Project: No
// Inventory Management: Yes (1 inventory)
// Activities: Up to 500 activities
// Material Management: Up to 400 materials
// Number of Users: 1 user
