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
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->integer('vehicle_id')->nullable();
            $table->integer('driver_id')->nullable();
            $table->integer('project_id')->nullable();
            $table->dateTime('start_date_time')->nullable();
            $table->dateTime('end_date_time')->nullable();
            $table->string('from_location')->nullable();
            $table->string('end_location')->nullable();
            $table->string('distance')->nullable();
            $table->text('description')->nullable();
            $table->text('notes')->nullable();
            $table->string('amount')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });

//         Vehicle ID
// Driver ID
// Start Date Time
// End Date Time
// from Location
// End Location
// Distance
// description
// Notes
// amount
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
