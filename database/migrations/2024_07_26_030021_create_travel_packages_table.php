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
        Schema::create('travel_packages', function (Blueprint $table) {
            $table->id();
            $table->string('countries')->nullable();
            $table->string('cities')->nullable();
            $table->string('traveler')->nullable();
            $table->string('duration')->nullable();
            $table->string('duration_night')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->mediumText('general_info')->nullable();
            $table->mediumText('travel_schedule')->nullable();
            $table->mediumText('additional_info')->nullable();
            $table->string('title')->nullable();;
            $table->string('price')->nullable();
            $table->bigInteger('author')->nullable();
            $table->mediumText('image_name')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('travel_packages');
    }
};
