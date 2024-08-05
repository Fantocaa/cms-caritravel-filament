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
        Schema::table('location_products', function (Blueprint $table) {
            $table->string('img_name')->after('cities')->nullable();
            $table->string('status')->after('img_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('location_products', function (Blueprint $table) {
            $table->dropColumn('img_name');
        });
    }
};
