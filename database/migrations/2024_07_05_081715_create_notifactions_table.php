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
        Schema::create('notifactions', function (Blueprint $table) {
            $table->id();
            $table->string('message')->nullable();
            $table->string('type')->nullable();
            $table->JSON('details')->nullable();
            $table->string('remarks')->nullable();
            $table->foreignId('user_id')->nullable()->references('id')->on('company_users')->onDelete('cascade');
            $table->foreignId('sender_id')->nullable()->references('id')->on('company_users')->cascadeOnDelete();
            $table->foreignId('company_id')->nullable()->references('id')->on('company_managments')->onDelete('cascade');
            $table->tinyInteger('status')->comment('0:unread,1:read,2:view')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifactions');
    }
};
