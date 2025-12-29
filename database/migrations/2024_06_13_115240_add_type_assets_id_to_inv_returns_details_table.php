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
        Schema::table('inv_returns_details', function (Blueprint $table) {
            $table->foreignId('assets_id')->nullable()->references('id')->on('assets')->onDelete('cascade')->after('remarkes');
            $table->string('type')->nullable()->after('remarkes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inv_returns_details', function (Blueprint $table) {
            //
        });
    }
};
