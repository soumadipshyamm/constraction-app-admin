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
        Schema::table('company_users', function (Blueprint $table) {
            $table->foreignId('country')->nullable()->constrained()->references('id')->on('countries')->onDelete('cascade');
            $table->foreignId('state')->nullable()->constrained()->references('id')->on('states')->onDelete('cascade');
            $table->foreignId('city')->nullable()->constrained()->references('id')->on('cities')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('company_users', function (Blueprint $table) {
            //
        });
    }
};
