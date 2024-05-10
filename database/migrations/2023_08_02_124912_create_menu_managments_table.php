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
        Schema::create('menu_managments', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('position')->nullable();
            $table->string('lable')->nullable();
            $table->string('type')->nullable();
            $table->string('url')->nullable();
            $table->string('site_page')->nullable();
            $table->tinyInteger('is_active')->default(true)->comment('0:Inactive,1:Active')->nullable();
            $table->tinyInteger('is_approve')->default(true)->comment('0:Unapproved,1:Approved')->nullable();
            $table->tinyInteger('is_blocked')->default(false)->comment('0:Unblocked,1:Blocked')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_managments');
    }
};
