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
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->foreignId('user_id')->unsigned()->references('id')->on('users');
            $table->morphs('mediaable');
            $table->string('media_type')->comment('Please add document or image description in this field');
            $table->string('file');
            $table->string('alt_text', 100)->nullable();
            $table->boolean('is_profile_picture')->default(0)->comment('0 = No, 1 = Yes');
            $table->json('meta_details')->nullable()->comment('Meta details are use for advertisement and seo purpose');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
