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
        Schema::table('inward_goods_details', function (Blueprint $table) {
            $table->foreignId('assets_id')->nullable()->references('id')->on('assets')->onDelete('cascade')->after('remarkes');
            $table->string('type')->nullable()->after('remarkes');
            $table->integer('accept_qty')->nullable()->after('remarkes');
            $table->integer('po_qty')->nullable()->after('remarkes');
            $table->decimal('price', 9, 3)->nullable()->after('remarkes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inward_goods_details', function (Blueprint $table) {
            //
        });
    }
};
